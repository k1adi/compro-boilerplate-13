<?php

test('the root url redirects to the default indonesian locale', function () {
    $response = $this->get('/');

    $response->assertRedirect('/id');
});
