
const select = document.getElementById('region');
//COMSUMIR LOS REGISTROS DE REGIONES Y COMUNA
select.addEventListener('click', () => {

    const url = `http://127.0.0.1/sistemaVotaciones/backend/src/controlador/region.php`;

    const api = new XMLHttpRequest();
    api.open('GET', url, true);
    api.send();

    api.onreadystatechange = function(){

        if(this.status == 200 && this.readyState == 4){

            const datos = JSON.parse(this.responseText);
            
                //CARGA DE REGIONES A SELECT 
                const regiones = datos.map(region => region.REGION);
                for (reg of regiones) {
                    const option = document.createElement('option');
                    option.value = reg;
                    option.textContent = reg;
                    select.appendChild(option);
                }  
                  
                //CARGA DE COMUNAS SEGUN LA REGION SELECCIONADA
                const selectValue = document.getElementsByName('region')[0].value;
                const comunas = datos.find(item => item.REGION === selectValue)?.COMUNAS; 
                const selectCom = document.getElementById('comuna');
                for (com of comunas) {
                    const option = document.createElement('option');
                    option.value = com;
                    option.textContent = com;
                    selectCom.appendChild(option);
                }                  
        }
    };
});



const selectCandi = document.getElementById('candidato');
//CONSUMIR LOS REGISTROS DE CANDIDATOS
selectCandi.addEventListener('click', () => {
  
    const url = `http://127.0.0.1/sistemaVotaciones/backend/src/controlador/candidato.php`;
    
    const api = new XMLHttpRequest();
    api.open('GET', url, true);
    api.send();
    
    api.onreadystatechange = function(){
        
        if(this.status == 200 && this.readyState == 4){
            
            const datos = JSON.parse(this.responseText);
            
            //CARGA DE CANDIDATOS A SELECT
            const candidatos = datos.map(candidato => candidato.nombre);
            for (candi of candidatos) {
                const option = document.createElement('option');
                option.value = candi;
                option.textContent = candi;
                selectCandi.appendChild(option);
            }    
        }
    };
});



