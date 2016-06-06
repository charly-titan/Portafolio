
function GenerateFileName() {
	var form = document.namingForm;
	var reg = /^[a-z0-9_]*$/;
	var regId = /^[0-9]*$/;
	var cal = form.startDateCal.value;
	//alert( cal.substring(5,7) + "/" + cal.substring(8,10) + "/" + cal.substring(0,4) + " " + cal.substring(11,13) + ":" + cal.substring(14,16) + ":00" );
	//alert("--" + cal + "--");
	if( form.geoblocking.options[form.geoblocking.selectedIndex].value == '' ||
		form.canal.options[form.canal.selectedIndex].value == '' ||
		form.program.options[form.program.selectedIndex].value == '' ||
		form.node.options[form.node.selectedIndex].value == '' ||
		form.time.options[form.time.selectedIndex].value == '' ||
		form.description.value == '' ||
		form.startDateCal.value == ''
		) {
		alert('Debes seleccionar todas las opciones');
	}
	else if( !form.masterCheck.checked && !form.renditionsCheck.checked ) {
		alert('Por lo menos selecciona una calidad');
	}
	else if( !reg.test(form.description.value ) ) {
		alert('El título debe estar:\n- Escrito sólo en minúsculas\n- Contener sólo letras, números y guión bajo "_"\n- No contener espacios, ñ o acentos');
	}
	else {
		if( form.renditionsCheck.checked )
			form.renditions.value = "R";
		if( form.galaxyCheck.checked )
                        form.renditions.value += "G";
		if( form.masterCheck.checked )
			form.renditions.value += "M"; 
		if( form.cq5Check.checked )
                        form.renditions.value += "Q";
		form.startDate.value = cal.substring(5,7) + "/" + cal.substring(8,10) + "/" + cal.substring(0,4) + " " + cal.substring(11,13) + ":" + cal.substring(14,16) + ":00";
		form.fileName.value = form.program.options[form.program.selectedIndex].value + "-" + form.description.value;

                var time = parseInt( form.time.options[form.time.selectedIndex].value );
                var fecha = new Date( parseInt(cal.substring(0,4)), (parseInt(cal.substring(5,7))-1), parseInt(cal.substring(8,10)), parseInt(cal.substring(11,13)), parseInt(cal.substring(14,16)), 0);
		var timestamp = fecha.getTime() / 1000;
		
		form.start.value = timestamp;
		form.end.value = timestamp + time;
		//alert(form.start.value + "-" + form.end.value);
		return true;
	}
	//alert( reg.test(form.description.value) );
	return false;
}
function SelectFormat( sel ) {
	var form = document.namingForm;
	if( sel.selectedIndex == 2 ) {
		form.node.selectedIndex = 0;
		//document.getElementById('rowId').style.display = "block";
		//document.getElementById('rowRama').style.display = "none";
		form.node.disabled = true;
		form.galaxyId.disabled = false;
		form.youtube.disabled = false;
	}
	else if( sel.selectedIndex == 3 ) {
		form.youtube.checked = false;	
		form.node.disabled = false;
		form.youtube.disabled = true;
	}
	else {
		//document.getElementById('rowId').style.display = "none";
		//document.getElementById('rowRama').style.display = "block";
		form.node.disabled = false;
		form.galaxyId.disabled = true;
		form.youtube.disabled = false;
	} 
}
function ClearForm() {
	form.fileName.value = '';
	form.description.value = '';
	form.node.value = '';
	form.channel.selectedIndex = 0;
	form.geoblocking.selectedIndex = 0;
	form.program.selectedIndex = 0;
	form.youtube.checked = false;
}
function DeleteGalaxyId() {
	var form = document.namingForm;
	form.galaxyId.value = '';
}
function ResetNode(text) {
	var form = document.namingForm;
	
	if( text.value != '' && text.value != null )
		form.node.selectedIndex = 0;
}


// Univisión
function ClearXmlForm() {
	var form = document.namingForm;
	form.category.selectedIndex = 0;
	form.title.value = '';
	form.description.value = '';
	form.programName.value = '';
	form.keywords.value = '';
	form.thumbnail.value = '';
	form.pubDate.value = '';
	form.duration.value = '';
	form.fileName.value = '';
}
function GenerateUnivisionXmlFile() {
	var form = document.namingForm;
	if( form.category.options[form.category.selectedIndex].value == '' || 
		form.title.value == '' ||
		form.description.value == '' ||
		form.programName.value == '' ||
		form.keywords.value == '' ||
		form.thumbnail.value == '' ||
		form.pubDate.value == '' ||
		form.duration.value == '' ||
		form.fileName.value == ''
		) {
		alert('Debes llenar todos los campos');
	}
	else {
		
		form.xml.value = '<?xml version="1.0" encoding="UTF-8"?>\n' +
			'<rss version="2.0" ' +
			'xmlns:content="http://purl.org/rss/1.0/modules/content/" ' +
			'xmlns:wfw="http://wellformedweb.org/CommentAPI/" ' +
			'xmlns:dc="http://purl.org/dc/elements/1.1/" ' +
			'xmlns:media="http://search.yahoo.com/mrss/" ' +
			'xmlns:atom="http://www.w3.org/2005/Atom">\n' +
			'	<channel>\n' +
			'	<title>tvolucion.com</title>\n' +
			'	<link>http://www.tvolucion.com</link>\n' +
			'	<description>Tvolucion es el sitio de videos oficial de Grupo Televisa, en el podras disfrutar gratis, de los mejores videos y capitulos completos de tus telenovelas, series y programas favoritos, ademas de peliculas clasicas y los videos mas relevantes de las noticias y los deportes. Tvolucion tambien te ofrece, sin costo alguno para Mexico, la mejor senal de television en vivo via internet.</description>\n' +
			'	<image>\n' +
			'		<title>tvolucion.com</title>\n' +
			'		<url>http://i2.esmas.com/tvolucion/img/head_l_tvolucion.gif</url>\n' +
			'		<link>http://www.tvolucion.com</link>\n' +
			'	</image>\n' +
			'	<language>es-mx</language>\n' +
			'	<copyright>2005 Comercio Mas S.A. de C.V</copyright>\n' +
			'	<managingEditor>videosantafe@esmas.com</managingEditor>\n' +
			'	<webMaster>feeds@esmas.com (feeds Esmas.com)</webMaster>\n' +
			'	<pubDate>Fri, 01 Feb 2013 10:16:21 GMT</pubDate>\n' +
			'	<lastBuildDate>Fri, 01 Feb 2013 10:16:21 GMT</lastBuildDate>\n' +
			'	<category>Tvolucion</category>\n' + 
			'	<generator>GALAXY 1.0</generator>\n' +
			'	<atom:link href="http://www.esmas.com" rel="self" type="application/rss+xml" />\n' +
			'	<ttl>60</ttl>\n' +
			'	  <item>\n' +
			'			<title><![CDATA[' + form.title.value + ']]></title>\n' +
			'			<link>http://www.televisa.com/</link>\n' +
			'			<description><![CDATA[' + form.description.value + ']]></description>\n' +
			'			<pubDate>' + form.pubDate.value + '</pubDate>\n' +
			'			<media:content url="' + form.fileName.value + '" fileSize="" type="video" medium="video" expression="clip" duration="' + form.duration.value + '" />\n' +
			'			<media:title type="plain"><![CDATA[' + form.programName.value + ']]></media:title>\n' +
			'			<media:credit role="author" scheme="' + form.programName.value + '"><![CDATA[' + form.programName.value + ']]></media:credit>\n' +
			'			<media:description type="plain"><![CDATA[' + form.description.value + ']]></media:description>\n' +
			'			<media:keywords><![CDATA[' + form.keywords.value + ']]></media:keywords>\n' +
			'			<media:thumbnail url="' + form.thumbnail.value + '"/>\n' +
			'			<guid isPermaLink="false">' + form.fileName.value + '</guid>\n' +
			'			<category><![CDATA[' + form.category.options[form.category.selectedIndex].value + ']]></category>\n' +          
			'	</item>\n' +
			'	</channel>\n' +
			'</rss>';
		document.getElementById('msgNameCreated').innerHTML = "Copia el contenido en un archivo de notepad con el mismo nombre del archivo de video y extensión xml"	
		form.xml.select();
	}
	return false;
}
