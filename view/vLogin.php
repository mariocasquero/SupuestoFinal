<section>
    <article>
        <form id="email" method="post" action="<?php echo $_SERVER["PHP_SELF"]?>">
            <input type="submit" name="correo" id="correo" value="Enviar Correo">
        </form>
        <iframe width="660px" height="400px" src="https://sway.com/s/OujaBUA0qeGO5DXY/embed" frameborder="0" marginheight="0" marginwidth="0" max-width="100%" sandbox="allow-forms allow-modals allow-orientation-lock allow-popups allow-same-origin allow-scripts" scrolling="no" style="border: none; max-width: 100%; max-height: 100vh" allowfullscreen mozallowfullscreen msallowfullscreen webkitallowfullscreen></iframe>
    </article>
</section>

<nav>
    <div class="reproductor">
        <input type="range" min="0" max="" value="0" step="1" id="dur" size="80">
        <div id="tiempo"></div>
        <div class="contenedor02">
            <i class="fas fa-step-backward" onclick="backward()"></i>
            <i class="far fa-play-circle" onclick="play()"></i>
            <i class="fas fa-step-forward" onclick="forward()"></i>
        </div>
            
        <i class="fas fa-volume-down" id="volMin" onclick="bajar()"></i>
            <input type="range" min="0" max="10" value="10"  id="vlm" size="80">
        <i class="fas fa-volume-up" id="volMax" onclick="subir()"></i>
    </div>
    
    <div class="diapositivas">
        
    </div>
</nav>

<aside>
    <div id="analogico">
        <div class="doce">
            <span id="doce">12</span>
        </div>

        <div  class="una">
            <span id="una">1</span>
        </div>

        <div  class="dos">
            <span id="dos">2</span>
        </div>

        <div  class="tres">
            <span id="tres">3</span>
        </div>

        <div  class="cuatro">
            <span id="cuatro">4</span>
        </div>

        <div  class="cinco">
            <span id="cinco">5</span>
        </div>

        <div  class="seis">
            <span id="seis">6</span>
        </div>

        <div  class="siete">
            <span id="siete">7</span>
        </div>

        <div  class="ocho">
            <span id="ocho">8</span>
        </div>

        <div  class="nueve">
            <span id="nueve">9</span>
        </div>

        <div  class="diez">
            <span id="diez">10</span>
        </div>

        <div  class="once">
            <span id="once">11</span>
        </div>
        
        <div id="centro"></div>

        <div id="horas"></div>

        <div id="minutos"></div>

        <div id="segundos"></div>
    </div>
    
    <div id="digital">
        
    </div>
</aside>

<script>
//Reloj digital            
    function reloj(){
        var horaActual=null; //Variable en la que se muestra formateada la hora por pantalla
        var reloj=new Date(); //Se instancia un objeto de la clase Date

        let hora=reloj.getHours(); //Se recoge la hora actual
        let minutos=reloj.getMinutes(); //Se recogen los minutos actuales
        let segundos=reloj.getSeconds(); //Se recogen los segundos actuales

        cadenaSegundos=new String(segundos);
        if(cadenaSegundos.length==1){
            segundos="0"+segundos;
        }

        cadenaMinutos=new String(minutos);
        if(cadenaMinutos.length==1){
            minutos="0"+minutos;
        }

        cadenaHoras=new String(hora);
        if(cadenaHoras.length==1){
            hora="0"+hora;
        }

        horaActual=hora+":"+minutos+":"+segundos;
        document.getElementById("digital").innerHTML=horaActual;
    }

    function ponerPila(){
        setInterval(reloj, 1000);
    }

    ponerPila();
</script>

<script>
    //Reloj analógico
    function analogico(){
        var horaActual=null; //Variable en la que se muestra formateada la hora por pantalla
        var reloj=new Date(); //Se instancia un objeto de la clase Date

        let hora=reloj.getHours(); //Se recoge la hora actual
        let minutos=reloj.getMinutes(); //Se recogen los minutos actuales
        let segundos=reloj.getSeconds(); //Se recogen los segundos actuales

        var posicionS=0;
        var posicionM=0;
        var posicionH=0;

        cadenaSegundos=new String(segundos);
        if(cadenaSegundos.length==1){
            segundos="0"+segundos;
        }

        cadenaMinutos=new String(minutos);
            if(cadenaMinutos.length==1){
                minutos="0"+minutos;
            }
        cadenaHoras=new String(hora);
            if(cadenaHoras.length==1){
                hora="0"+hora;
            }

        horaActual=hora+":"+minutos+":"+segundos;

        posicionH=(360/12*hora)+(minutos*0.5);
        posicionM=360/60*minutos;
        posicionS=360/60*segundos;

        document.getElementById("horas").style.transform="rotate("+posicionH+"deg)";
        document.getElementById("minutos").style.transform="rotate("+posicionM+"deg)";
        document.getElementById("segundos").style.transform="rotate("+posicionS+"deg)";
    }

    function ponerHora(){
        setInterval(analogico, 1000);
    }

    ponerHora();
</script>

<script>
    //Reproductor música
    var miCancion=new Audio("webroot/media/cancion03.mp3");
    var playPause=false;
    var playP=document.getElementsByTagName("I")[2];
    var volumen=document.getElementById("vlm");
    var tiempo, segundos, minutos, bola, transcurrido;
    segundos=0;
    minutos=0;

    function tiempo(){            
        bola=document.getElementById("dur");
        bola.setAttribute("max", miCancion.duration);

        transcurrido=Math.round(miCancion.currentTime);

        segundos=transcurrido%60;

        if(segundos>=59){
            minutos=Math.round(segundos/60);
            segundos=0;
        }

            segundos=segundos.toString();

            minutos=minutos.toString();

            if(segundos.length==1){
                    segundos="0"+segundos;
            }

            if(minutos.length==1){
                    minutos="0"+minutos;
            }

            bola.value=miCancion.currentTime;
            tiempo=minutos+":"+segundos;
            document.getElementById("tiempo").innerHTML=tiempo;
    }

    function duracion(){
            setInterval(tiempo, 1000);
    }

    vlm.addEventListener("change", function(evt){
        miCancion.volume=evt.currentTarget.value;
    }, true);

    dur.addEventListener("change", function(evt){
        miCancion.currentTime=evt.currentTarget.value;
    }, true);

    function play(){
        if(playPause){
            playP.setAttribute("class", "far fa-play-circle");
            miCancion.pause();
            playPause=false;
        }
        else{
            playP.setAttribute("class", "far fa-pause-circle");
            miCancion.play();
            playPause=true;
        }
    }

    function backward(){
        miCancion.currentTime=0;
        segundos=0;
        minutos=0;
    }

    function forward(){
        miCancion.currentTime=miCancion.duration;
    }

    function subir(){
        console.log(miCancion.volume+ "ANTES SUBIR:" + volumen.value);
        miCancion.volume+=0.1;
        volumen.value ++;
        console.log(miCancion.volume+ "DES SUBIR:" + volumen.value);
    }

    function bajar(){
        console.log(miCancion.volume+ "ANTES bajar:" + volumen.value);
        miCancion.volume-=0.1;
        volumen.value--; 
        console.log(miCancion.volume+ "DES bajar:" + volumen.value);
    }
</script>
    