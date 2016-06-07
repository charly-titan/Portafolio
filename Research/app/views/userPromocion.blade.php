<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<style>
		body {
			margin:0;
			font-family:'Lato', sans-serif;
			color: #999;
		}

		.welcome {
			width: 900px;
			height: 100px;
			position: absolute;
			top: 5%;
			margin-left: -100px;
			margin-top: -50px;
		}

		a, a:visited {
			text-decoration:none;
		}

		h1 {
			font-size: 32px;
			margin: 16px 0 0 0;
			text-align: center;
			padding: .5em;
		}

		table{
			margin: auto;
			width: 70%;
			padding-top: 2em;
			font-size: 12px;

		}
		tr td{
			padding: .3em;
		}
		td{
			/*border: 1px solid black;*/
			height: 20px;
    		vertical-align: bottom;
    		padding: 15px;
		}

td {
    background-color: #eae8e7;
    color:black;
}
	</style>
</head>
<body>
	<div class="welcome">
		<h1>Participantes</h1>
		
			@foreach ($properties as $key => $value)
				<table>
					<tr>
						<td>Nombre :</td><td>{{Crypt::decrypt($value->first_name)}} {{Crypt::decrypt($value->last_name)}}</td>
					</tr>
					<tr>
						<td>Email :</td><td>{{Crypt::decrypt($value->email_hash)}}</td>
					</tr>
					<tr>
						<td>Genero :</td><td>{{$value->gender}}</td>
					</tr>
					<tr>
						<td>Telefono :</td><td>{{Crypt::decrypt($value->tel)}}</td>
					</tr>
					<tr>
						<td>Cumpleaños :</td><td>{{$value->birthdate}}</td>
					</tr>
					<tr>
						<td>Pais :</td><td>{{$value->country}}</td>
					</tr>
					<tr>
						<td>Ciudad :</td><td>{{$value->state}}</td>
					</tr>
					<tr>
						<td>Edad:</td><td>{{$value->age}}</td>
					</tr>
					<tr>
						<td>Concurso:</td><td>{{$value->contest}}</td>
					</tr>
					<tr>
						<td>Red Social:</td><td>{{$value->social_network}}</td>
					</tr>
					<tr>
						<td>Frase:</td><td>{{$value->phrase}}</td>
					</tr>
					<tr>
						<td>Registro:</td><td>{{$value->created_at}}</td>
					</tr>
				</table>
			@endforeach
		
	</div>
	<div>
		

	</div>
</body>
</html>
