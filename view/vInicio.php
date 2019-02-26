<h2 class="cabecera">Inicio</h2>

<form method="post" action="<?php echo $_SERVER["PHP_SELF"]?>" id="fBusqueda">
    <div class="criterioBus">    
        <label>Descripción </label>
        <input type="text" name="descripcionJamon" size="30" value="<?php echo $_REQUEST["descripcionJamon"]?>">
        <input type="submit" name="buscarJamon" id="buscar" value="Buscar">
        <input type="submit" name="salir" id="salir" value="Salir">
    </div>
    <br><br>
    <div class="table-responsive w-75">
        <table class="table table-striped table-bordered text-warning table-dark table-sm">
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
                    echo "<td class='descripcion'>".$jamones[$i]->getDescJamon()."</td>";
                    echo "<td class='centrado'>".$jamones[$i]->getPrecioJamon()."</td>";
                    echo "<td class='centrado'>".$jamones[$i]->getTipoJamon()."</td>";
                    echo "<td><form method='post'><button onclick='addUser(username.value,password.value)' type='submit' class='sinFondo' name='anyadirJamon"; echo $i."'><i class='far fa-plus-square'></i></button></form></td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>
    
    <aside id="verUser">
        
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
                    db=openDatabase("UsuarioDB", "0.1", "Jamones BBDD", 2*1024*1024);
                    if(db){
                            db.transaction(function(tx){
                                    tx.executeSql("create table if not exists Producto(jamonid integer primary key autoincrement, descripcion text, tipo text)");
                            });
                    }
                    listarJamones();
            }

            function addJamon(descripcion, tipo){
                    db.transaction(function(tx){
                            tx.executeSql("INSERT INTO Producto(descripcion, tipo) VALUES (?,?)", [descripcion, tipo]);
                    });
                    listarJamones();
            }

            function listarJamones(){
                    db.transaction(function(tx){
                            tx.executeSql("SELECT * FROM Producto", [], function(tx, result){
                                    var salida=[];
                                    for(i=0; i<result.rows.length; i++){
                                            salida.push([result.rows.item(i)['jamonid'], result.rows.item(i)['descripcion'], result.rows.item(i)['tipo']]);
                                    }
                                    visualizaRegistros(salida);
                            });
                    });
            }

            function visualizaRegistros(users){
                    var ver=document.getElementById("verUser");
                    if(ver.getElementsByTagName("UL").length>0){
                            ver.removeChild(ver.getElementsByTagName("UL")[0]);
                    }
                    var lista=document.createElement("UL");
                    for(i=0; i<users.length; i++){
                            var elemento=document.createElement("LI");
                            elemento.innerHTML+="<b>Id Jamón: </b>"+users[i][0]+"<b> Descripción Jamón: </b>"+users[i][1]+"<b> Tipo: </b>"+users[i][2]+" <button onclick='borrarJamon("+users[i][0]+")'>Borrar Elemento</button>";
                            lista.appendChild(elemento);
                    }
                    ver.appendChild(lista);
            }

            function borrarUsuario(usuarioBorrar){
                    db.transaction(function(tx){
                            tx.executeSql("DELETE FROM Producto where jamonid=?", [usuarioBorrar], listarJamones());
                    });
            }

            function borrarTabla(){
                    db.transaction(function(tx){
                            tx.executeSql("DELETE FROM Producto");
                            listarUsers()
                    })
            }
    </script>
</form>

