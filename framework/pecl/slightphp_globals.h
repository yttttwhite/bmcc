/*{{{LICENSE
+-----------------------------------------------------------------------+
| slightphp Framework                                                   |
+-----------------------------------------------------------------------+
| This program is free software; you can redistribute it and/or modify  |
| it under the terms of the GNU General Public License as published by  |
| the Free Software Foundation. You should have received a copy of the  |
| GNU General Public License along with this program.  If not, see      |
| https://www.gnu.org/licenses/.                                         |
| Copyright (C) 2008-2009. All Rights Reserved.                         |
+-----------------------------------------------------------------------+
| Supports: https://www.slightphp.com                                    |
+-----------------------------------------------------------------------+
}}}*/
#ifdef HAVE_CONFIG_H
	#include "config.h"
#endif

int debug(char*format,...);
int slightphp_load(zval*appDir,zval*zone,zval*class_name TSRMLS_DC);
int slightphp_loadFile(char*file_name TSRMLS_DC);
int slightphp_run (zval*zone,zval*class_name,zval*method,zval*return_value ,int param_count,zval *params[] TSRMLS_DC);
int preg_quote(zval *in_str,zval*out_str);
