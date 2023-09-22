@extends('layouts.app')

@section('css')
    <style>
        .fab-container {
            position:fixed;
            bottom:50px;
            right:50px;
            cursor:pointer;
        }

        .icon-button {
            width: 50px;
            height: 50px;
            border-radius: 100%;
            background: #FF4F79;
            /* box-shadow: 10px 10px 5px #aaaaaa; */
        }

        .button {
            width: 60px;
            height: 60px;
            /* background: #A11692; */
        }

        .icon-button svg {
            /* display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #fff; */
        }
    </style>
    
@endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <h5>Test page</h5>
                </div>
                <hr>
                <div class="cambioRuta d-flex justify-content-end">
                    <div class="">
                        <button class="btn btn-danger" onclick="addToList()">Cerrar ciclo</button>
                    </div>
                    <div class="">
                        <button class="btn btn-primary">Cambiar ruta</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fab-container">
        <button class="button icon-button" onclick="getRackInformation()">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#fff" class="bi bi-check-lg" viewBox="0 0 16 16">
                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
            </svg>
        </button>
    </div>

    @section('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

        
        {{-- New Functions --}}
        {{-- <script>
            const nuevoBoton = document.createElement('button');
            nuevoBoton.innerText = 'Test button';
            // nuevoBoton.className = 'btnLarge ant-btn ant-btn-primary'
            nuevoBoton.className = 'btnLarge ant-btn'
            nuevoBoton.style = 'background-color: #cc7435; border-color: #cc7435; color: #fff';
            
            nuevoBoton.onclick = 'sendData()';


            const rowButtons = document.getElementsByClassName('cambioRuta');
            // rowButtons[0].firstChild.appendChild(nuevoBoton);
            rowButtons[0].firstChild.prepend(nuevoBoton);

            // rowButtons.firstChild.firstElementChild

            // nuevoBoton.onclick = function() { console.log('Pressed') };
        </script> --}}

        {{-- <script>
            setTimeout(() => {
            const nuevoBoton = document.createElement('button');
            nuevoBoton.innerText = 'Test button';
            // nuevoBoton.className = 'btnLarge ant-btn ant-btn-primary'
            nuevoBoton.className = 'btnLarge ant-btn'
            nuevoBoton.style = 'background-color: #cc7435; border-color: #cc7435; color: #fff';

        //     const floatingActionButton = document.createElement('div');
        //     // floatingActionButton.className = 'fab tool';
        //     // floatingActionButton.setAttribute('data-bs-toggle', 'modal');
        //     // floatingActionButton.setAttribute('data-bs-target', '#modalUbicacion');
        //     floatingActionButton.innerHTML = `
        //         <div class="fab-wrapper">
        //         <button type="button" class="fab tool" data-bs-toggle="modal" data-bs-target="#modalUbicacion">
        //             <span class="tooltiptext">Agregar ubicación</span>
        //             <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="#fff" class="bi bi-plus" viewBox="0 0 16 16">
        //                 <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        //             </svg>
        //         </button>
        //     </div>`

        // document.getElementsByClassName('inner-content').appendChild(floatingActionButton);
            
            // nuevoBoton.onclick = 'sendData()';


            const rowButtons = document.getElementsByClassName('cambioRuta');
            // rowButtons[0].firstChild.appendChild(nuevoBoton);
            rowButtons[0].firstChild.prepend(nuevoBoton);

            // rowButtons.firstChild.firstElementChild

            // nuevoBoton.onclick = function() { console.log('Pressed') };
            nuevoBoton.onclick = getRackInformation();


            
            }, 6000);
        </script> --}}

        {{-- Jala chido en producción --}}
        <script>
            setTimeout(() => {
            const nuevoBoton = document.createElement('button');
            nuevoBoton.innerText = 'Test button';
            // nuevoBoton.className = 'btnLarge ant-btn ant-btn-primary'
            nuevoBoton.className = 'btnLarge ant-btn'
            nuevoBoton.style = 'background-color: #cc7435; border-color: #cc7435; color: #fff';

        //     const floatingActionButton = document.createElement('div');
        //     // floatingActionButton.className = 'fab tool';
        //     // floatingActionButton.setAttribute('data-bs-toggle', 'modal');
        //     // floatingActionButton.setAttribute('data-bs-target', '#modalUbicacion');
        //     floatingActionButton.innerHTML = `
        //     <div class="fab-wrapper">
        //     <button type="button" class="fab tool" data-bs-toggle="modal" data-bs-target="#modalUbicacion">
        //         <span class="tooltiptext">Agregar ubicación</span>
        //         <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="#fff" class="bi bi-plus" viewBox="0 0 16 16">
        //             <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        //         </svg>
        //     </button>
        // </div>`

        // document.getElementsByClassName('inner-content').appendChild(floatingActionButton);
            
            nuevoBoton.onclick = 'sendData()';


            const rowButtons = document.getElementsByClassName('cambioRuta');
            // rowButtons[0].firstChild.appendChild(nuevoBoton);
            rowButtons[0].firstChild.prepend(nuevoBoton);

            // rowButtons.firstChild.firstElementChild

            // nuevoBoton.onclick = function() { console.log('Pressed') };
            // nuevoBoton.onclick = getRackInformation;

            nuevoBoton.onclick = addToList;
            


            
            }, 6000);

            // const addToList = async() => {
            async function addToList() {
            console.log('Add to list');
                const pedidoHC = localStorage.getItem("pedidoActual");
                const listaPedidoHC = pedidoHC ? JSON.parse(pedidoHC) : [];
                console.log(pedidoHC);

                const response = await fetch('http://10.40.129.40:99/rack-system/api/get/rack-info-api');

                const json = await response.json();

                console.log(json);

                json.data.forEach(element => {
                    // console.log(element);
                    listaPedidoHC.push(element);
                    localStorage.setItem("pedidoActual", JSON.stringify(listaPedidoHC));

                    // Row
                    `
                    <td _ngcontent-vbk-c173="" nzleft="" class="ant-table-cell-fix-left-last ant-table-cell ant-table-cell-fix-left" style="position: sticky; left: 0px;">
                    ${element}
                    </td>`

                    // Table body
                    const tbody = document.getElementsByClassName('ant-table-tbody ng-star-inserted');
                    console.log(tbody[0]);
                });

            }
        </script>

{{-- 
        <script>
            const getRackInformation = () => {
                // localStorage.setItem("pedidoActual", ["uno", "dos", "tres"]);
                // const testObj = JSON.stringify(
                const testObj =
                    {
                        "area": "ASSEMBLY DOORS",
                        "cantidad_solicitada": 1,
                        "area" :  "ASSEMBLY DOORS",
                        "cantidad_solicitada":  1,
                        "descripcion":  "}-16 X 1/2 HW TLR SS",
                        "folio":  "002837",
                        "folioCreado" :  "2023-05-02 08:45",
                        "max":  2,
                        "min":  1,
                        "parte":  "8281163",
                        "quien_solicita":  "Usuario prueba",
                        "reg" :  "106545",
                        "ruta" :  "1J",
                        "status" :  "pendiente",
                        "tipo_requerimiento" :  "e-kanban",
                        "ubicacion_almacen" :  "PS16/PS5D2",
                        "ubicacion_linea" :  "LEPC 030FC KIT",
                    };
                
                    const list = ["cero", "uno", "dos"];


                localStorage.setItem( "pedidoActual", JSON.stringify([testObj]) );

                


                
            }

            const addToList = () => {
                let pedido = localStorage.getItem("pedidoActual");
                let listaPedido = pedido ? JSON.parse(pedido) : [];
                
                $.ajax({
                    type: "GET",
                    url: 'get/rack-info',
                    dataType: "json",
                    success: function({data}) {
                        // console.log(data);
                        data.forEach(element => {
                            console.log(element);
                            listaPedido.push(element);
                            localStorage.setItem("pedidoActual", JSON.stringify(listaPedido));
                        });
                    }
                });


                let pedido = localStorage.getItem("pedidoActual");
                let listaPedido = pedido ? JSON.parse(pedido) : [];

                // const response = await fetch('get/rack-info');
                const response = await fetch('http://10.40.129.40:99/rack-system/api/get/rack-info-api', {
                    mode: "no-cors"
                });

                const json =  response.json();

                console.log(json);

                json.data.forEach(element => {
                    console.log(element);
                    listaPedido.push(element);
                    localStorage.setItem("pedidoActual", JSON.stringify(listaPedido));
                });


                
                // console.log("Add to list");
                // let pedido = localStorage.getItem( "pedidoActual" );
                // let lista = pedido ? JSON.parse(pedido) : [];
                // const obj =
                //     {
                //         "area": "ASSEMBLY DOORS",
                //         "cantidad_solicitada": 1,
                //         "area" :  "ASSEMBLY DOORS",
                //         "cantidad_solicitada":  1,
                //         "descripcion":  "}-16 X 1/2 HW TLR SS",
                //         "folio":  "002837",
                //         "folioCreado" :  "2023-05-02 08:45",
                //         "max":  2,
                //         "min":  1,
                //         "parte":  "8281163",
                //         "quien_solicita":  "Usuario prueba",
                //         "reg" :  "106545",
                //         "ruta" :  "1J",
                //         "status" :  "pendiente",
                //         "tipo_requerimiento" :  "e-kanban",
                //         "ubicacion_almacen" :  "PS16/PS5D2",
                //         "ubicacion_linea" :  "LEPC 030FC KIT",
                //     };
                // lista.push(obj);
                // localStorage.setItem("pedidoActual", JSON.stringify(lista));
            }



        </script> --}}
        
    @endsection
    
@endsection

