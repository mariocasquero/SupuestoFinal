<h2 class="cabecera">Inicio</h2>

<form method="post" action="<?php echo $_SERVER["PHP_SELF"]?>" id="fBusqueda">
    <div class="criterioBus">    
        <label>Descripción </label>
        <input type="text" name="descripcionJamon" size="30" value="<?php echo $_REQUEST["descripcionJamon"]?>">
        <input type="submit" name="buscarJamon" id="buscar" value="Buscar">
        <input type="submit" name="salir" id="salir" value="Salir">
    </div>
    <br><br>

        <table>
            <thead>
                <th>Código</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Tipo</th>
            </thead>

            <?php
                $i=0;
                for($i=0; $i<count($jamones); $i++){
                    echo "<tr>";
                    echo "<td class='centrado'>".$jamones[$i]->getCodJamon()."</td>";
                    echo "<td class='descripcion' id='descJamon'>".$jamones[$i]->getDescJamon()."</td>";
                    echo "<td class='centrado' id='precioJamon'>".$jamones[$i]->getPrecioJamon()."</td>";
                    echo "<td class='centrado' id='tipoJamon'>".$jamones[$i]->getTipoJamon()."</td>";
                    echo "<td><form method='post'><button type='submit' class='sinFondo' name='anyadirJamon"; echo $i."'><i class='far fa-plus-square' onclick='addJamon(descJamon, precioJamon, tipoJamon, $i)'></i></button></form></td>";
                    echo "</tr>";
                }
            ?>
        </table>
    
    <aside id="verProductos">
        
    </aside>
    
    <div class="paginas">
        <?php
            //PAGINACIÓN
            if($pag>1){
                echo "<a href='?pagina=".($pag-1)."&descripcionJamon=".$_REQUEST['descripcionJamon']."'><< ".ANTERIOR." </a>";
            }
            if($pag<$totalPaginas){
                echo "<a href='?pagina=".($pag+1)."&descripcionJamon=".$_REQUEST['descripcionJamon']."'>".SIGUIENTE." >></a>";
            }            
        ?>
    </div>
    <script>
        //Objeto DB Global
        var db;
        function init(){
            db=openDatabase("Jamones", "0.1", "Jamones BBDD", 2*1024*1024);
            if(db){
                db.transaction(function(tx){
                        tx.executeSql("create table if not exists Productos(jamonid integer primary key autoincrement, descripcionJamon text, precioJamon int, tipoJamon text)");
                });
            }
            listarJamones();
        }
        
        function addJamon(descripcion, precio, tipo, indice){
            db.transaction(function(tx){
                tx.executeSql("insert into Productos(descripcionJamon, precioJamon, tipoJamon) VALUES (?,?,?)", [descripcion[indice].innerText, precio[indice].innerText, tipo[indice].innerText]);
            });
            listarJamones();
        }
        
        function listarJamones(){
            db.transaction(function(tx){
                tx.executeSql("SELECT * FROM Productos", [], function(tx, result){
                    var salida=[];
                        for(i=0; i<result.rows.length; i++){
                            salida.push([result.rows.item(i)['jamonid'], result.rows.item(i)['descripcionJamon'], result.rows.item(i)['precioJamon'], result.rows.item(i)['tipoJamon']]);
                        }
                        visualizaRegistros(salida);
                });
            });
        }
        
        function visualizaRegistros(jamones){
            var ver=document.getElementById("verProductos");
            if(ver.getElementsByTagName("UL").length>0){
                ver.removeChild(ver.getElementsByTagName("UL")[0]);
            }
            var lista=document.createElement("UL");
            for(i=0; i<jamones.length; i++){
                var elemento=document.createElement("LI");
                elemento.innerHTML+="<b>ID jamón: </b>"+jamones[i][0]+"<b> Descripción jamón: </b>"+jamones[i][1]+"<b> Precio jamón: </b>"+jamones[i][2]+" <button onclick='borrarJamon("+jamones[i][0]+")'>Borrar Jamón</button>";
                lista.appendChild(elemento);
            }
            ver.appendChild(lista);
        }
        
        function borrarJamon(jamonBorrar){
            db.transaction(function(tx){
                tx.executeSql("delete from Productos where jamonid=?", [jamonBorrar], listarJamones());
            });
            console.log(jamonBorrar);
        }
    </script>
</form>

