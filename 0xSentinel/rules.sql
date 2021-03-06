INSERT INTO `0xSentinel_rules` (`type`, `regola`, `descrizione`)
VALUES 
('sql', '/select.+from.+(where)?.+/im', 'Blind SQL Injection'),
('sql', '/(''|&quot;)?.+or.+(''|&quot;)?.+/im', 'SQL Injection'),
('sql', '/(--|drop|alter|create|union|select|order|by|and)/im', 'SQL Injection'),
('sql', '/insert.+into.+value.+/im', 'SQL Injection'),
('sql', '/union.+(all).?+select.+from.+(where)?.+/im', 'SQL Injection'),
('lfi', '/(\\\.\\\.\\\/(.+)|\\\.\\\.\\\/|(.+)\\\/)/im', 'Local File Inclusion'),
('xss', '/(?:[^:\\\s\\\w]+\\\s*[^\\\w\\\/](href|protocol|host|hostname|pathname|hash|port|cookie)[^\\\w])/im', 'Cross Site Scripting'),
('rfi', '/^(http|https|ftp|webdav)\\\:\\\/\\\/(www\\\.)?.+(\\\.[A-Za-z]{1-4})?/im', 'Remote File Inclusion'),
('xss', '/<[^>]*(script|onclick|object|frame|iframe|frameset|img|applet|meta|style|form|onmouse|body|input|head|html)*"?[^>]*>/im', 'Cross Site Scripting'),
('log_poisoning', '/.*<\\\s*\\\?\\\s*(php)?.+\\\??\\\s*>?.*/im', 'Log Poisoning'),
('lfi', '/(etc\\\/passwd|etc\\\/passwd|etc\\\/shadow|etc\\\/group|etc\\\/security\\\/passwd|etc\\\/security\\\/user)/i', 'Local File Inclusion'),
('sql', '/update.+set.+/im', 'SQL Injection'),
('sql', '/and.+[0-9]=[0-9]/im', 'SQL Injection'),
('xss', '@%26%23[0-9]+|%3C+[^*]+%3E|string\\\.+fromcharcode|%5C\\\.[uU]003[cC]+[^*]+%5C\\\.[uU]003[cC]@m', 'Cross Site Scripting'),
('xss', '/(?:"[^"]*[^-]?>)|(?:[^\\\w\\\s]\\\s*\\\/>)|(?:>")/im', 'Cross Site Scripting'),
('xss', '/(?:[\\\s\\\d\\\/"]+(?:on\\\w+|style|poster|background)=[$"\\\w])/im', 'Cross Site Scripting'),
('xss', '/(?:^>[\\\w\\\s]*<\\\/?\\\w{2,}>)/im', 'Cross Site Scripting'),
('xss', '/(?:[=(].+\\\?.+:)|(?:with\\\([^)]*\\\)\\\))|(?:\\\.\\\s*source\\\W)/im', 'Cross Site Scripting'),
('lfi', '/(?:(?:\\/|\\\\)?.+(\\/|\\\\)(?:\\.+)?)|(?:\\w+\\.exe??\\s)|(?:;\\s*\\w+\\s*\\/[\\w*-]+\\/)|(?:\\d\\.\\dx\\|)|(?:%(?:c0\\.|af\\.|5c\\.))|(?:\\/(?:%2e){2})/im', 'Directory Traversal'),
('xss', '/(?:%u(?:ff|00|e\\\d)\\\w\\\w)|(?:(?:%(?:e\\\w|c[^3\\\W]|))(?:%\\\w\\\w)(?:%\\\w\\\w)?)/im', 'Cross Site Scripting'),
('xss', '/(?:[&quot;.]script\\s*\\()|(?:\\$\\$?\\s*\\(\\s*[\\w&quot;])|(?:\\/[\\w\\s]+\\/\\.)|(?:=\\s*\\/\\w+\\/\\s*\\.)|(?:(?:this|window|top|parent|frames|self|content)\\[\\s*[(,&quot;]*\\s*[\\w$])|(?:,\\s*new\\s+\\w+\\s*[,;)])/im', 'Cross Site Scripting'),
('xss', '/(?:[^:\\\s\\\w]+\\\s*[^\\\w\\\/](href|protocol|host|hostname|pathname|hash|port|cookie)[^\\\w])/im', 'Cross Site Scripting'),
('xss', '/(?:\\\\x[01fe][\\db-ce-f])|(?:%[01fe][\\db-ce-f])|(?:&amp;#[01fe][\\db-ce-f])|(?:\\\\[01fe][\\db-ce-f])|(?:&amp;#x[01fe][\\db-ce-f])/im', 'Null Byte (XSS)'),
('sql', '/(?:&quot;\\s*or\\s*&quot;?\\d)|(?:\\\\x(?:23|27|3d))|(?:^.?&quot;$)|(?:(?:^[&quot;\\\\]*(?:[\\d&quot;]+|[^&quot;]+&quot;))+\\s*(?:n?and|x?or|not|\\|\\||\\&amp;\\&amp;)\\s*[\\w&quot;[+&amp;!@(),.-])|(?:[^\\w\\s]\\w+\\s*[|-]\\s*&quot;\\s*\\w)|(?:@\\w+\\s+(and|or)\\s*[&quot;\\d]+)|(?:@[\\w-]+\\s(and|or)\\s*[^\\w\\s])|(?:[^\\w\\s:]\\s*\\d\\W+[^\\w\\s]\\s*&quot;.)/im', 'SQL Injection'),
('sql', '/\\\/\\\*(.+)?(\\\*\\\/)?/im', 'SQL Injection');
