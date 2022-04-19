var fs = require('fs');
var usernames = {};
/*var dl = require('delivery');*/
/* If you are using SSL, uncomment the below lines*/
/*
var options = {
    key: fs.readFileSync('/var/www/html/YOUR_CERTIFICATE_FOLDER/your_project_key.key'),
    cert: fs.readFileSync('/var/www/html/YOUR_CERTIFICATE_FOLDER/your_project_crt.crt'),
    ca: fs.readFileSync('/var/www/html/YOUR_CERTIFICATE_FOLDER/your_project_ca-bundle.ca-bundle')
};
var app = require('https').createServer(options, handler);
*/
 
var app = require('http').createServer(handler); // For non-ssl server
var io = require('socket.io').listen(app);
app.listen(3002);
function handler (req, res) {
  try {  
	res.writeHead(200);
    res.end("Welcome to socket.io.");
  }catch(e){
	console.log(e);
  }
}
/** This section is for receiving and sending message **/
var Room;
var Room1;

function uniqArry(str1,flag) {
var arr = str1.split(",");
  var i,
      len=arr.length,
      out=[],
	  obj={};  

  for (i=0;i<len;i++) {
    obj[arr[i]]=0;
  }
  for (i in obj) {
    out.push(i);
  }
  if(flag != 0){
	var indx = out.indexOf(flag);
	if (indx >= 0) {
	  out.splice( indx, 1 );
	}
  }    
  return out.join();
}

io.sockets.on('connection', function (socket) {
	socket.on('subscribeTo', function (data) {
        if(Room){
            socket.leave(Room);
        }
        Room = data.channel;
        console.log('Connecting client to: '+data.channel);        
        socket.join(data.channel);		
		/*var index=data.channel;
		index = index.replace("login_","");					
		if(data.channel.indexOf("login") != -1){
			 uid=data.userId;//+"~~"+data.lastLogin+"~~"+data.lastLogout;
			 usernames[index]=(typeof usernames[index] !='undefined')?usernames[index]+","+uid:uid;
			 usernames[index]= uniqArry(usernames[index],0);
			 console.log(usernames[index]);        
			 io.in(data.channel).emit('iotoclientlogin', { message: usernames[index]});
		}*/
    });
    socket.on('iotoserver', function (data) {
		socket.broadcast.to(data.channel).emit('iotoclient', { message: data.message });
		console.log(data);
    });	
});
/*******************Chat logic goes here ******************/
io.sockets.on('connection', function (socket) {
	socket.on('subscribeToChat', function (data) {     
        console.log('Connecting client to: '+data.channel);        
        socket.join(data.channel);			
    });
    socket.on('iotoserverchat', function (data) {
		socket.broadcast.to(data.channel).emit('iotoclientchat', { message: data.message });
		console.log(data);
    });	
	socket.on('iotoserverlogout', function (data) {
		socket.broadcast.to(data.channel).emit('iotoclientlogout', { message: data.message });
		console.log(data);
    });
	socket.on('iotoservertypo', function (data) {
		socket.broadcast.to(data.channel).emit('iotoservertypo', { message: data.msg});
		console.log(data);
    });
	/** Chant group logic ***/
	socket.on('subscribeToGroup', function (data) {
		socket.join(data.channel);
		console.log('Connecting client to[GROUP]: '+data.channel);
	});
	 socket.on('iotoservergroup', function (data) {
		socket.broadcast.to(data.channel).emit('iotogroup', { message: data.message });
		console.log(data);
    });	
	/*** Chat group logic ***/
	
});



