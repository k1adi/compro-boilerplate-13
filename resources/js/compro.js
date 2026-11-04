import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';

Alpine.plugin(focus);
Alpine.plugin(collapse);

Alpine.data('comproShell', () => ({
    mobileOpen: false,
    scrolled: false,
    darkMode: document.documentElement.classList.contains('dark'),

    init() {
        const handleScroll = () => {
            this.scrolled = window.scrollY > 12;
        };
        handleScroll();
        window.addEventListener('scroll', handleScroll, { passive: true });
    },

    toggleTheme() {
        this.darkMode = !this.darkMode;
        document.documentElement.classList.toggle('dark', this.darkMode);
        try {
            localStorage.setItem('compro_theme', this.darkMode ? 'dark' : 'light');
        } catch {
            // Storage unavailable in restricted privacy modes
        }
    },

    closeMobileMenu() {
        this.mobileOpen = false;
    },
}));

Alpine.data('rfqForm', (config) => ({
    status: config.initialSuccess ? 'success' : 'idle',
    errors: {},
    successData: config.initialSuccess || null,
    form: {
        full_name: config.old?.full_name || '',
        company_name: config.old?.company_name || '',
        work_email: config.old?.work_email || '',
        phone_whatsapp: config.old?.phone_whatsapp || '',
        service_code: config.selectedService || 'SRV-01',
        facility_location: config.old?.facility_location || '',
        estimated_capacity: config.old?.estimated_capacity || '',
        project_brief: config.old?.project_brief || '',
        company_website_hp: '',
    },

    hasErrors() {
        return Object.keys(this.errors).length > 0;
    },

    fieldError(name) {
        return this.errors[name] ? this.errors[name][0] : null;
    },

    async submitForm(event) {
        this.status = 'submitting';
        this.errors = {};

        try {
            const response = await fetch(event.target.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': config.csrfToken,
                },
                body: JSON.stringify(this.form),
            });

            const payload = await response.json();

            if (response.status === 422) {
                this.status = 'error';
                this.errors = payload.errors || {};
                return;
            }

            if (!response.ok) {
                this.status = 'error';
                this.errors = {
                    general: [payload.message || 'Request failed. Please try again.'],
                };
                return;
            }

            this.status = 'success';
            this.successData = payload;
        } catch {
            this.status = 'error';
            this.errors = {
                general: ['Network error occurred. Please check your connection or contact our WhatsApp desk.'],
            };
        }
    },

    resetForm() {
        this.status = 'idle';
        this.errors = {};
        this.successData = null;
        this.form.project_brief = '';
        this.form.estimated_capacity = '';
    },
}));

window.Alpine = Alpine;
Alpine.start();

