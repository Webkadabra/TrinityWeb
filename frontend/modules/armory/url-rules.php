<?php
return [
    'character/<server:[^\/]+>/<character:[^\/]+>/talents' => 'character/talents',
    'character/<server:[^\/]+>/<character:[^\/]+>'         => 'character/index',
    '<server:[^\/]+>/<query:[^\/]+>'                       => 'default/index',
    '/'                                                    => 'default/index',
];