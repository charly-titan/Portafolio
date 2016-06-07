socket = io('http://node-listen.sinpk2.com:8000');

socket.on('connect_error', function(err) {
	alert('sin conexion a la app')});
var SimpleFilterableList = React.createClass({
	componentDidMount: function() {
		var instance = this;
		var downloadData = function() {
			$.ajax({
				url: 'http://node-listen.sinpk2.com:8000/api/list',
				dataType: 'json',
				success: function(lista) {
					instance.setState({
						simpleList: lista
					});
					//pagination();
				}.bind(instance),
				error: function(xhr, status, err) {
				}.bind(instance),
			});
		};
		downloadData();
		socket.on('change', function(data) {
			downloadData();
		});
	},
	getInitialState: function() {
		return {
			userInput: "",
			simpleList: [{
				row: 'cargando...'
			}]
		};
	},
	updateUserInput: function(input) {
		this.setState({
			userInput: input.target.value
		});
	},

	render: function() {
		return (
		        <div id="busqueda" className="well well-sm">
		        <div className="form-group">
		        <div className="icon-addon addon-md">
		        <input type="text" placeholder="Email" className="form-control"
		        id = 'userInput'
		        type = 'text'
		        placeholder = 'Filtro por titulo...'
		        onChange = {this.updateUserInput}/>
		        <label className="glyphicon glyphicon-search"></label>
		        </div>
		        </div>
		        <SimpleList simpleList = {this.state.simpleList}
		        userInput = {this.state.userInput}/>
		        </div>
		        );
	}
});


var SimpleList = React.createClass({
	render: function() {
		return (
		        <div className="smart-timeline">
		        <SimpleListRow simpleList = {this.props.simpleList}
		        userInput = {this.props.userInput}/>

		        </div >
		        );
	}
});


var SetIntervalMixin = {
	componentWillMount: function() {
		this.intervals = [];
	},
	setInterval: function() {
		this.intervals.push(setInterval.apply(null, arguments));
	},
	componentWillUnmount: function() {
		this.intervals.forEach(clearInterval);
	}
};

var SimpleListRow = React.createClass({
mixins: [SetIntervalMixin], // Use the mixin
getInitialState: function() {
	return {seconds: 0, cate: 0};
},

componentDidMount: function() {
this.setInterval(this.tick, 1000); // Call a method on the mixin
},

tick: function() {
	this.setState({cate: $('#mxm_cat').val(), seconds: this.state.seconds + 1});
},

render: function() {
	var rows = this.props.simpleList;
	var userInput = this.props.userInput;
	var seconds =  this.state.seconds;
	var categoria =  this.state.cate;
	return (
	        <ul className = 'event-list' > {

	        	rows.map(function(element) {
	        		if (element.sitio === categoria) {
	        			var epoch_db_utc = element.unix_time.toString().split(".")[0];
	        			var epoch_db_utc = epoch_db_utc.substr(0,10);
	        			var epoch_db_utc = (epoch_db_utc * 1000);
	        			var epoch_db = new Date(epoch_db_utc);
	        			var dia_db = epoch_db.toString()
	        			.split(" ")[2];
	        			var mes_db = epoch_db.toString()
	        			.split(" ")[1];
	        			var date_db = epoch_db.toLocaleTimeString();
	        			var horas_db = date_db.toString()
	        			.split(":")[0];
	        			var mins_db = date_db.toString()
	        			.split(":")[1];
	        			var time_db = epoch_db.toLocaleTimeString();
	        			var epoch_actual = new Date();
	        			var date_actual = epoch_actual.toLocaleTimeString();
	        			var horas_actual = date_actual.toString()
	        			.split(":")[0];
	        			var mins_actual = date_actual.toString()
	        			.split(":")[1];
	        			if (element.title) {
	        				if (element.title.toLowerCase().search(userInput.toLowerCase()) > -1) {
	        					if ((horas_actual - horas_db) < 1) {
	        						if ((mins_actual - mins_db) < 1) {
	        							var time_db = time_db;
	        						}
	        					};
	        					var url = "https://s3-us-west-1.amazonaws.com/communities-dev";
	        					if (!element.img){
	        						var destination = "ultima-hora/local/mxm/";
	        						var filename = "../default.jpg";
	        						var img_url = 'http://icons.iconarchive.com/icons/guillendesign/variations-3/96/Default-Icon-icon.png'
	        					} else {
	        						var img_url = element.img[0].url;
	        					};
	        					if (!element.url){
	        						element.url = "http://noticieros.televisa.com/ultima-hora/";
	        					} else {
	        							element.url = element.url;
	        					};
	        					return (
	        					        <li key = {element.id}
	        					        id = {element.id}
	        					        onDoubleClick = {this.mxm_getElement.bind(this, element.id)}>
	        					        <time>
	        					        <span className="day">{dia_db}</span>
	        					        <span className="month">{mes_db}</span>
	        					        </time>
	        					        <img className="img-responsive" src={img_url} />
	        					        <div className="info">
	        					        <h4 className="title margin-bottom-0">
	        					        <a href={element.url} target="_blank" id="link">{element.title}
	        					        </a> <small> {time_db} </small>
	        					        </h4>
	        					        <p className="desc">{element.text}</p>
	        					        </div>
	        					        </li>
	        					        );

	        				}
	        			}
	        		};
	        	})}
< /ul>
);}}
);
