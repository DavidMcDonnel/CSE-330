var http = require("http"),
	socketio = require("socket.io"),
	fs = require("fs");
	
 
// Listen for HTTP connections.  This is essentially a miniature static file server that only serves our one file, client.html:
var app = http.createServer(function(req, resp){
	// This callback runs when a new connection is made to our HTTP server.
 
	fs.readFile("COL.html", function(err, data){
		// This callback runs when the client.html file has been read from the filesystem.
 
		if(err) return resp.writeHead(500);
		resp.writeHead(200);
		resp.end(data);
	});
});
app.listen(3456);
var users = {
	name:[],
	id:[]
	};
	
var sockets = [];
var rooms = {
	names:[],
	passwords:[],
	admin:[],
	users:[]
	};
var blacklist = {
	names:[],
	rooms:[]
};

var io = socketio.listen(app);
io.sockets.on("connection", function(socket){
	io.sockets.emit('rooms',rooms);
	
	socket.on('user_login', function(data){
		if (users.name.indexOf(data)!= -1) {
			socket.room="global";
			socket.join("global");
			socket.name=data;
			io.sockets.emit("message_to_client", {message:data+" has logged in"});
			
			
		} else{
			socket.room="global";
			socket.join("global");
			socket.name=data;
			users.name.push(data);
			users.id.push(socket.id);
			io.sockets.emit("message_to_client", {message:data+" has logged in"});
			
		}

	});
	
	socket.on('create_private_room', function(room,room_pass,admin){
		socket.join(room);
		socket.room=room;
		rooms.names.push(room);
		rooms.passwords.push(room_pass);
		rooms.admin.push(admin);
		rooms.users.push(admin);
		io.sockets.emit('user_connect',JSON.stringify(rooms));
	});
	
	socket.on('kick_user', function(user,admin){
		var roomindex = rooms.admin.indexOf(admin);
		var user_index = users.name.indexOf(user);
		console.log(user+" kicked by "+admin);
		io.sockets.emit('discon_client',user,"kick");
	});
	
	socket.on('ban_user', function(user,admin){
		var roomindex = rooms.admin.indexOf(admin);
		var user_index = users.name.indexOf(user);
		console.log(user+" banned by "+admin);
		blacklist.names.push(user);
		blacklist.rooms.push(rooms.names[roomindex]);
		io.sockets.emit('discon_client',user,"ban");
	});
	
	socket.on('private_override', function(user,room){
		var roomindex = rooms.names.indexOf(room);
		socket.join(room);
		socket.room=room;
		if (rooms.names.indexOf(user)=== -1) {
			rooms.users.push(user);
			rooms.names.push(room);
		}
		io.sockets.emit('user_connect',JSON.stringify(rooms),socket.name);
	});
	
	socket.on('invite', function(user,admin,room){
		io.sockets.emit('user_invite',user,admin,room);	
	});
	
	socket.on('kick_me', function(user){
		console.log("in kick_me");
		var user_index = users.name.indexOf(user);
		if (user_index > -1) {
			console.log("in if");
			console.log(socket.room);
			socket.leave(socket.room);
			socket.room="global";
			socket.join("global");
			console.log(socket.room);
			rooms.users.splice(user_index, 1);
			rooms.names.splice(user_index, 1);
		}
	});
	
	
	
	//function discon(user,roomindex){
	//	console.log(user);
	//	socket.name(user)
	//	if (socket.name===user) {
	//		console.log(user+" is disconnecting");
	//		var user_index = users.name.indexOf(user);
	//		while (user_index > -1) {
	//		    rooms.users.splice(user_index, 1);
	//		    rooms.names.splice(user_index, 1);
	//		}
	//		socket.leave(rooms.names[roomindex]);
	//		socket.room="global";
	//		socket.join("global");
	//	}
	//}
	
	socket.on('join_private_room', function(room,room_pass,user){
		var roomindex = rooms.names.indexOf(room);
		
		if (!((blacklist.names.indexOf(user)!= -1) && (blacklist.names.indexOf(user)===blacklist.rooms.indexOf(room)))) {
			if (room_pass===rooms.passwords[roomindex]) {
				socket.join(room);
				socket.room=room;
				if (rooms.names.indexOf(user)=== -1) {
					rooms.users.push(user);
					rooms.names.push(room);
				}
				console.log(rooms);
			}
			io.sockets.emit('user_connect',JSON.stringify(rooms),socket.name);
		}
	});
	
	socket.on('create_room', function(data){
		socket.join(data);
		socket.room=data;
		rooms.names.push(data);
		rooms.users.push(socket.name);
		io.sockets.emit('user_connect',JSON.stringify(rooms));
	});
	
	socket.on('join_room', function(data){
		if (!((blacklist.names.indexOf(socket.name)!= -1) && (blacklist.names.indexOf(socket.name)===blacklist.rooms.indexOf(data)))) {
			socket.join(data);
			socket.room=data;
			if (rooms.users.indexOf(data)=== -1) {
				rooms.users.push(socket.name);
				rooms.names.push(data);
			}
			io.sockets.emit('user_connect',JSON.stringify(rooms),socket.name);
		}
	});
	
	socket.on('message_to_server', function(data) {
		console.log("message: "+data["message"]);
		console.log("socket.room " + socket.room);
		io.in(socket.room).emit("message_to_client",{message:data["message"] });
		
	});
	
	socket.on("private_message", function(message,username,usr){
		console.log("message: "+message+"to "+username);
		var userIndex = users.name.indexOf(username);
		io.sockets.emit('sentPrivateMessage',message["message"],username["username"],usr["usr"]);
	});
});