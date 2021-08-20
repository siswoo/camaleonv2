<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp API - by Gabriel Chávez</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.2.0/tailwind.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="w-full max-w-xs">
        <form id="form" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Nombre
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="name" id="name" type="text" placeholder="Ingresa tu nombre" value="juan" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Apellidos
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="lastname" id="lastname" type="text" placeholder="Ingresa tus apellidos" value="maldonado" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Correo
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="email" id="email" type="email" placeholder="Ingresa tu correo" value="juanmaldonado.co@gmail.com" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Teléfono
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="phone" id="phone" type="phone" placeholder="Ingresa tú numero Celular" value="3148597354" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    País
                </label>
                <select class="form-control" name="pais" id="pais" required>
                	<option value="">Seleccione</option>
                	<option value="54">Argentina</option>
                	<option value="591">Bolivia</option>
                	<option value="55">Brasil</option>
                	<option value="56">Chile</option>
                	<option value="57">Colombia</option>
                	<option value="506">Costa Rica</option>
                	<option value="53">Cuba</option>
                	<option value="593">Ecuador</option>
                	<option value="503">El Salvador</option>
                	<option value="594">Guayana Francesa</option>
                	<option value="1">Granada</option>
                	<option value="502">Guatemala</option>
                	<option value="592">Guayana</option>
                	<option value="509">Haití</option>
                	<option value="504">Honduras</option>
                	<option value="1">Jamaica</option>
                	<option value="52">México</option>
                	<option value="505">Nicaragua</option>
                	<option value="595">Paraguay</option>
                	<option value="507">Panamá</option>
                	<option value="51">Perú</option>
                	<option value="1">Puerto Rico</option>
                	<option value="1">República Dominicana</option>
                	<option value="597">Surinam</option>
                	<option value="598">Uruguay</option>
                	<option value="58">Venezuela</option>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button id="submit"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    <i class="fab fa-whatsapp"></i> Enviar WhatsApp
                </button>
            </div>
        </form>
        <p class="text-center text-gray-500 text-xs">
            Desarrollado por: <b><a target="_blank" href="#">Juan Maldonado</a></b>
        </p>
    </div>


    <div class="col-12">
    	<a href="send?phone=573016984868&text=*_Formulario" target="_blank">Aqui</a>
    </div>
    <script src="https://kit.fontawesome.com/1e268974cb.js" crossorigin="anonymous"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/helpers.js"></script>
    <script src="js/whatsapp.js"></script>
</body>

</html>