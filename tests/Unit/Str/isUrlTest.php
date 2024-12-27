<?php 

use function lray138\GAS\Str\isUrl;

it('validates a correct URL', function () {
    $validUrl = "https://www.example.com";
    expect(isUrl($validUrl))->toBeTrue();
});

it('validates an incorrect URL', function () {
    $invalidUrl = "not_a_valid_url";
    expect(isUrl($invalidUrl))->toBeFalse();
});

it('validates an empty string', function () {
    $emptyString = "";
    expect(isUrl($emptyString))->toBeFalse();
});

it('validates a URL without scheme', function () {
    $urlWithoutScheme = "www.example.com";
    expect(isUrl($urlWithoutScheme))->toBeFalse();
});

it('validates a URL with special characters', function () {
    $urlWithSpecialChars = "https://example.com/path?query=123&name=test#section";
    expect(isUrl($urlWithSpecialChars))->toBeTrue();
});