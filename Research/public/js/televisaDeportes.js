// tutorial2.js
/*var CommentList = React.createClass({
  render: function() {
    return (
      <div className="commentList">
        Hello, world! I am a CommentList.
      </div>
    );
  }
});

var CommentBox = React.createClass({displayName: 'CommentBox',
  render: function() {
    return (
      React.createElement('div', {className: "commentBox"},
        "Hello, world! I am a CommentBox."
      )
    );
  }
});*/

/*var CommentList = React.createClass({displayName:'CommentList',
	render: function(){
		return (
			React.createElement('div',{className:'commentList'},'Hello, world! I am a CommentList.')
			);
	}
});

var CommentForm = React.createClass({
  render: function() {
    return (
      <div className="commentForm">
        Hello, world! I am a CommentForm.
      </div>
    );
  }
});



var CommentBox = React.createClass({
  render: function() {
    return (
      <div className="commentBox">
        <h1>Comments</h1>
        <CommentList />
        <CommentForm />
      </div>
    );
  }
});*/


//clase que crea la lista de tareas
var Avatar = React.createClass({

		getInitialState: function() {
		    return {
		      id_tweet: '',
		      repos: <li>No repos yet.</li>
		    };
		  },
		componentDidMount: function() {
    		var self = this;



			      	$.ajax('http://research-static.televisa.com/twitter_services/979310a3-7bc3-4ed5-912a-cdd113c2f43a.json').done(function(data){
				      var x = JSON.parse(data);

				      self.setState({
				        repos: x.map(function(repo){
				        	console.log(repo)
				          return (<div><img src={repo.photo}></img><span>{repo.text}</span></div>);
				        })
				      });
				    });


				    '<div class="twitts">'+
						'<div id="id_tw_{{$index}}">'+
							'<div class="img">'+
								'<img src="{{tweet.photo}}"></img>'+
							'</div>'+
							'<div class="text">'+
								'<span class="twitt-title"></span>'+
								'<span class="twitt-user">'+
									'<a href="https://twitter.com/{{tweet.screen_name}}" target="_blank">@{{tweet.screen_name}}</a>'+
								'</span>'+
								'<p class="comentario" ng-bind-html=tweet.text></p>'+
								'<p class="time">{{tweet.created_at}}&nbsp;'+
									'<a href="https://twitter.com/intent/tweet?in_reply_to={{tweet.id_tweet}}" target="_blank">&#183; responder &nbsp;</a>'+
									'<a href="https://twitter.com/intent/retweet?tweet_id={{tweet.id_tweet}}" target="_blank">&#183; retweet &nbsp;</a>'+
									'<a href="https://twitter.com/intent/favorite?tweet_id={{tweet.id_tweet}}" target="_blank">&#183; favorito</a>'+
								'</p>'+
							'</div>'+
						'</div>'+
					'</div>'

		  },


          render: function() {
				    return (
					      <section>
					        {this.state.repos}
					      </section>
				    );
			}
        });
 


ReactDOM.render(
  React.createElement(Avatar, null),
  document.getElementById('content')
);
