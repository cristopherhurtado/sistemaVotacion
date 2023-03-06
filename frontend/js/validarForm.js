const form = document.querySelector("#formulario");
const parrafo = document.querySelector("#warnings");


form.addEventListener('submit', e => {
  e.preventDefault()
  
  let warnings = "";
  let msg = false;
  parrafo.innerHTML = "";
  
  
  //VALIDACION INPUT NOMBRE Y APELLIDO (NO DEBE QUEDAR EN BLANCO)
    const nombre = document.querySelector("#nombre");
    if (nombre.value.length == 0){
        nombre.style.border = '1px solid red';
        warnings += `Nombre y apellido. No debe estar vacio <br>`;
        msg = true
    }else {
        nombre.style.border = '1px solid green';
    }

    //VALIDACION INPUT ALIAS (DEBE SER MAYOR A 5 CARACTER Y TENER LETRAS Y NUMEROS)
    const alias = document.querySelector("#alias");
    const regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,}$/;
    if (regex.test(alias.value) == false) {
        alias.style.border = '1px solid red';
        warnings += `Alias. Debe ser mayor a 5 caracter con letras y numeros <br>`;
        msg = true
    }else {
        alias.style.border = '1px solid green';
    }

    //FUNCION QUE VALIDA RUT CHILENO
    const validarRut = (rut) => {

      // Eliminar puntos y guión verificador del RUT
      rut = rut.replace(/\./g, "");
      rut = rut.replace(/\-/g, "");
    
      // Separar dígito verificador del resto del RUT
      var cuerpoRut = rut.slice(0, -1);
      var dv = rut.slice(-1).toUpperCase();
    
      // Calcular suma ponderada de los dígitos del RUT
      var suma = 0;
      var multiplo = 2;
      for (var i = 1; i <= cuerpoRut.length; i++) {
        var index = multiplo * rut.charAt(cuerpoRut.length - i);
        suma = suma + index;
        multiplo = multiplo + 1;
        if (multiplo === 8) {
          multiplo = 2;
        }
      }
    
      // Calcular dígito verificador esperado
      var dvEsperado = 11 - (suma % 11);
      if (dvEsperado === 10) {
        dvEsperado = "K";
      } else if (dvEsperado === 11) {
        dvEsperado = "0";
      } else {
        dvEsperado = dvEsperado.toString();
      }
    
      // Comparar dígito verificador esperado con el recibido
      if (dv !== dvEsperado) {
        return false;
      } else {
        return true;
      }
    };

    //VALIDACION INPUT RUT (DEBE VALIDAR RUT CHILENO)
    const rut = document.querySelector("#rut");
    if (validarRut(rut.value) == false) {
      rut.style.border = '1px solid red';
      warnings += `RUT. Invalido. Ejemplo xx.xxx.xxx-x | xxxxxxxx-x <br>`;
      msg = true
    }else {
      rut.style.border = '1px solid green';
    }
    
    //VALAIDACION INPUT EMAIL (DEBE VALIDAR EMAIL CORRECTO)
    const email = document.querySelector("#email");
    const regexEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!regexEmail.test(email.value)){
      email.style.border = '1px solid red';
      warnings += `Email. Invalido ejemplo email@dominio.cl <br>`;
      msg = true
    }else {
      email.style.border = '1px solid green';
    }

    //VALIDACION SELECT REGION (NO DEBE ESTAR VACIO)
    const region = document.querySelector("#region");
    if (region.value.length == 0){
      region.style.border = '1px solid red';
      warnings += `Seleccione una region <br>`;
      msg = true
    }else {
      region.style.border = '1px solid green';
    }

    //VALIDACION SELECT COMUNA (NO DEBE ESTAR VACIO)
    const comuna = document.querySelector("#comuna");
    if (comuna.value.length == 0){
      comuna.style.border = '1px solid red';
      warnings += `Seleccione una comuna <br>`;
      msg = true
    }else {
      comuna.style.border = '1px solid green';
    }

    //VALIDACION SELECT CANDIDATO (NO DEBE ESTAR VACIO)
    const candidato = document.querySelector("#candidato");
    if (candidato.value.length == 0){
      candidato.style.border = '1px solid red';
      warnings += `Seleccione un candidato <br>`;
      msg = true
    }else {
      candidato.style.border = '1px solid green';
    }

    //VALIDA CHECKBOX (DEBEN SER ELEJIDOS ALOMENOS 2)
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var numSeleccionados = 0;
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
          numSeleccionados++;
        }
      }
      if (numSeleccionados < 2) {
        warnings += `Seleccione al menos 2 checkbox <br>`;
        msg = true
      }

    // INCRUSTAR MENSAJE DE VALIDACION 
    if (msg){
        parrafo.innerHTML = warnings;
    }

});









































