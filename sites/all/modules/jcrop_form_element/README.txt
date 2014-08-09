-------------------------------------------------------------------------------
Jcrop Form Element for Drupal 7.x
	by ADCI, LLC team - http://www.adcisolutions.com/
-------------------------------------------------------------------------------
Dscription:
This module provides an integration of popular jquery library Jcrop with the Drupal FAPI. 
Basically it provides a new form element which can be used in your custom forms. This is 
an API module mostly intended for developers.

Usage:
Can be used in any custom forms or for altering existing forms. New form element 'jcrop_image'  
is similar to 'managed_file' and can be used instead of them, but for images of course. For 
example you can create a form with a webform module and add File component. On hook_form_alter 
you can simply change the type of the file field to 'jcrop_image'. Also 'jcrop_image' form 
element has #jcrop_settings array that allows to control the Jcrop API object on the client side.

Installation:
Download and install the Libraries API 2 module and the Jcrop Form Element module as a normal module.
Then download the Jcrop plugin into libraries directory sites/all/libraries/jcrop.

Dependences: 
Libraries API 2, File, Image.