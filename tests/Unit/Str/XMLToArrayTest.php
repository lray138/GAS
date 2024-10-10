<?php 

use function lray138\GAS\Str\XMLToArray;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertEmpty;

it('converts valid XML to an array', function () {
    $xml = <<<XML
    <root>
        <item>
            <name>Item 1</name>
            <value>Value 1</value>
        </item>
        <item>
            <name>Item 2</name>
            <value>Value 2</value>
        </item>
    </root>
    XML;

    $expected = [
        'root' => [
            'item' => [
                ['name' => 'Item 1', 'value' => 'Value 1'],
                ['name' => 'Item 2', 'value' => 'Value 2'],
            ]
        ]
    ];

    $result = XMLToArray($xml);

    assertEquals($expected, $result);
});

it('returns an empty array for invalid XML', function () {
    $invalidXml = '<root><item></root>'; // Invalid XML with missing closing tag

    $result = XMLToArray($invalidXml);

    assertEmpty($result);
});