const formMixin = {
    methods: {
        validatename(cadena) {
            let specialChars = "!@#$^&%*()+=-[]\/{}|:<>?,.";
            
            //Elimina los caracteres
            for (let i = 0; i < specialChars.length; i++) {
              cadena= cadena.replace(new RegExp("\\" + specialChars[i], 'gi'), '');
            }
            //conviente a minuscula
            cadena = cadena.toLowerCase();
            
            //eliminamso acentos y ñ
            cadena = cadena.replace(/á/gi,"a");
            cadena = cadena.replace(/é/gi,"e");
            cadena = cadena.replace(/í/gi,"i");
            cadena = cadena.replace(/ó/gi,"o");
            cadena = cadena.replace(/ú/gi,"u");
            cadena = cadena.replace(/ñ/gi,"n");
            
            return cadena
        }
    }
}
