# Project HORUS | 2023, Version 3

									PROJECT IN DEVELOPMENT HORUS | 2023 


![HORUS | 2023](https://github.com/tarsicio/REACT_LARAVEL9/blob/master/src/assets/img/horus.png)


![HORUS | 2023](https://github.com/tarsicio/REACT_LARAVEL9/blob/master/src/assets/img/laravel.jpeg)


Help me have a coffee, every bean counts

![HORUS | 2023](https://github.com/tarsicio/REACT_LARAVEL9/blob/master/src/assets/img/usdt100.png)

USDT Wallet : 0x2701ceabb6c061f937cd7107fb97ee18ce63c90d

Greetings to all,

HORUS Project | 2023 Version 3 (PHP | LARAVEL | REACT-UI | SWAGGER | API-REST)

At this time (2022-12-26) I am developing the HORUS | 2023, which consists of two (2) parts.

The first part(https://github.com/tarsicio/API_REST_LARAVEL_9/tree/master) is being developed in PHP in its version 8, and using the Laravel Framework in its version 9, it is an API-REST, which contains everything necessary to function as a Base application (User Management, Roles, Permission , between many other things).

And the second(https://github.com/tarsicio/REACT_LARAVEL9/tree/master) is the UI environment, which is made under React.

All this is under construction, I will upload as fast as time allows, constant updates until the project is finished.
                                        
If you wish you can use Version 2 of HORUS | 2022, which is made entirely under the Laravel 8 Framework, which is 100% operational, you can download it from the following GITHUB repository. https://github.com/tarsicio/Laravel08BaseApp
                                                                                                                                              
Version 3 of this project has everything that was done in version 2, of the Laravel Framework, I am passing it to API-REST.

Very important to take into account.

in the class

Illuminate\Foundation\Auth\ResetsPasswords;

which is in \vendor -> in the method

protected function resetUrl($notifiable),

You must comment the following lines of code:

return url(route('password.reset', [
             'token' => $this->token,
             'email' => $notifiable->getEmailForPasswordReset(),
         ], false));

and instead put:
 
return 'localhost:5173/password/reset/'.$this->token.'?email='.$notifiable->getEmailForPasswordReset();

You must do all this, so that the sending via email of the link to reset the password works correctly, you feel free to adjust according to your URL for the one that best suits your situation.

Thanks for your support.

Att,

Tarsicio Carrizales (telecom.com.ve@gmail.com)

Cabudare - Venezuela

December 26, 2022

| - | - | - | - | - | - | - | - | - | - | - | - | - | - | - | - | - | - | - | - | - | -| - | - | - | - | - | - | - |

									PROYECTO EN DESARROLLO HORUS | 2023

![HORUS | 2023](https://github.com/tarsicio/REACT_LARAVEL9/blob/master/src/assets/img/horus.png)


![HORUS | 2023](https://github.com/tarsicio/REACT_LARAVEL9/blob/master/src/assets/img/laravel.jpeg)


Ayudame a Tomarme un Café, Cada Grano Cuenta

![HORUS | 2023](https://github.com/tarsicio/REACT_LARAVEL9/blob/master/src/assets/img/usdt100.png)

Billetera USDT : 0x2701ceabb6c061f937cd7107fb97ee18ce63c90d

Saludos a todos,

Proyecto HORUS | 2023 Versión 3 (PHP | LARAVEL | REACT-UI | SWAGGER | API-REST)

En este tiempo(2022-12-26) me  encuentro desarrollando la aplicación HORUS | 2023, la cual consta de dos(2) partes.

La primera parte(https://github.com/tarsicio/API_REST_LARAVEL_9/tree/master) esta desarrollándose en PHP en su versión 8, y utilizando el Framework Laravel en su versión 9, la misma es una API-REST, la cual contiene todo lo necesario para funcionar como una aplicación Base(Manejo de Usuarios, Roles, Permiso, entre muchas otras cosas).

Y la segunda(https://github.com/tarsicio/REACT_LARAVEL9/tree/master) es el entorno UI, la cual esta realizado bajo React.

Todo esto esta en construcción, iré subiendo tan rápido como el tiempo me lo permita, actualizaciones contante hasta terminar el proyecto.
                                        
Si lo deseas puedes utilizar la Versión 2 de HORUS | 2022, la cual esta realizada en su totalidad bajo el Framework Laravel 8, la cual está en funcionamiento al 100%, la puedes descargar del siguiente repositorio de GITHUB. https://github.com/tarsicio/Laravel08BaseApp
                                                                                                                                              
La versión 3 del presente proyecto tiene todo lo que se realizó en la versión 2, del Framework de Laravel, lo estoy pasando a API-REST.

Muy importante, a tomar en cuenta.

en la clase 

Illuminate\Foundation\Auth\ResetsPasswords; 

la cual esta en \vendor -> en el metodo 

protected function resetUrl($notifiable), 

debes de comentar las siguientes líneas de código: 

return url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

y en su lugar colocar:
 
return 'localhost:5173/password/reset/'.$this->token.'?email='.$notifiable->getEmailForPasswordReset();

debes realizar todo esto, para que funcione correctamente el envío a través del correo electrónico del link para restablecer la contraseña, usted sientase en la libertad de ajustar de acuerdo a su URL por la que mejor se ajuste a su situación. 


Gracias por su Apoyo.

Att,

Tarsicio Carrizales (telecom.com.ve@gmail.com)

Cabudare -  Venezuela

26 de Diciembre del año 2022
