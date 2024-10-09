<?php

use function lray138\GAS\Str\beforeNth;

it('returns the substring before the nth occurrence of the delimiter', function () {
    expect(beforeNth(2, '/', 'a/b/c'))->toBe('a/b');
    expect(beforeNth(1, '/', 'a/b/c'))->toBe('a');
    expect(beforeNth(3, '/', 'a/b/c'))->toBe('a/b/c');
    expect(beforeNth(1, ',', 'apple,banana,cherry'))->toBe('apple');
    expect(beforeNth(2, ',', 'apple,banana,cherry'))->toBe('apple,banana');
});

it('handles cases where nth occurrence exceeds the number of delimiters', function () {
    expect(beforeNth(4, '/', 'a/b/c'))->toBe('a/b/c'); // No delimiter after the third one
    expect(beforeNth(2, ',', 'apple'))->toBe('apple'); // Only one occurrence
});

it('handles empty string and delimiter edge cases', function () {
    expect(beforeNth(1, '/', ''))->toBe(''); // Empty string
    expect(beforeNth(1, '', 'abcdef'))->toBe(''); // Empty delimiter
    expect(beforeNth(1, '/', '/a/b/c'))->toBe(''); // Delimiter at start
    expect(beforeNth(2, '/', '/a/b/c'))->toBe('/a'); // Delimiter in middle
});