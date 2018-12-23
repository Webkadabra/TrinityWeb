<?php
return [
    'team/<server:[^\/]+>/<teamId>'                => 'team/index',
    '<server:[^\/]+>/<type:\d+>/<page>/<per-page>' => 'default/index',
    '<server:[^\/]+>/<type>'                       => 'default/index',
    '/'                                            => 'default/index',
];