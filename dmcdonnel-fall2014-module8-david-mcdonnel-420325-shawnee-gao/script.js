

var init_nav = function() {
    $(".nav li div").hover(function() {
        $(this).stop().animate({
            scrollTop: $(this)[0].scrollHeight
        }, 400);
    }, function() {
        $(this).stop().animate({
            scrollTop: 0
        }, 400)
    });
    $(".nav li div").click(function() {
        var display = $(this).attr("name");
        var id = $(this).attr("id");
        if ($("#" + display).css("display") != "none") {
            $("#" + display).animate({
                    height: "toggle"
                },
                400,
                function() {
                    $(".nav li div").animate({
                        height: "70px"
                    }, 200, function() {
                        $(".nav li div").css("border-radius", "1ex 1ex 0 0");
                    });
                });
        } else {
            $(".tab").hide();
            $(".nav li div").height("70px").css("border-radius", "1ex 1ex 0 0");
            $(this).css("border-radius", "0");
            $(this).animate({
                    height: "80px"
                },
                200,
                function() {
                    $("#" + display).animate({
                        height: "toggle"
                    }, 400)
                }
            );
        }
    });
    $(".tab .close").click(function() {
        var tab = $(this).parent();
        $(tab).animate({
            height: "toggle"
        }, 400, function() {
            $(".nav li div").animate({
                height: "70px"
            }, 200, function() {
                $(".nav li div").css("border-radius", "1ex 1ex 0 0");
            });
        });
    });
};
var init_login = function() {
    $("#login_popup .close").click(function() {
        $(this).parent().hide();
    });
    $("#loginLink").click(function() {
        $("#login_popup").show();
    });
};
var init_register = function() {
    $('#register_popup .close').click(function() {
        $(this).parent().hide();
    });
    $('#registerLink').click(function() {
        $('#register_popup').css('display', 'block');
    });
};
$(function() {
    $('#submitRegister').click(function() {
        var desiredName = document.getElementById('registerUsername').value;
        var desiredPass = document.getElementById('registerPassword').value;
        var confirmPass = document.getElementById('confirmPassword').value;
	var phonenum =document.getElementById('phone').value
        if (desiredPass != confirmPass) {
            $('#register_popup').append('please confirm your password');
        } else {
            var data = {
                username: desiredName,
                password: desiredPass,
                confirm: confirmPass,
		phone: phonenum
            };
            $.ajax({
                type: 'POST',
                url: 'register.php',
                data: data,
                complete: function(data) {
                    var response = $.parseJSON(data.responseText);
                    if (response.success) {
                        document.getElementById('registerUsername').value = '';
                        document.getElementById('registerPassword').value = '';
                        document.getElementById('confirmPassword').value = '';
			document.getElementById('phone').value = '';
                        document.getElementById('register_popup').style.display = 'none';
                    } else {
                        $('#register_popup').append(response.message);
                    }
                }
            });
        }
    });
})
/*var init_fbusr_session = function(id, name) {
    var data = {
        fb: true,
        userid: id,
        username: name
    };
    $.ajax({
        type: 'POST',
        url: 'login.php',
        data: data,
        complete: function(data) {
            var response = $.parseJSON(data.responseText);
            if (response.success) {}
        }
    });
};
$(function() {
    $('#login-button-fb').click(function() {
        FB.login(function(response) {
            FB.getLoginStatus(function(response) {
                var name = '';
                if (response.status === 'connected') {
                    var fbname = '';
                    var uid = response.authResponse.userID;
                    var accessToken = response.authResponse.accessToken;
                    var fburl = 'http://graph.facebook.com/' + uid;
                    $.getJSON(fburl, function(data) {
                        fbname = data.first_name;
                        name = data.name;
                        document.getElementById('welcome').style.display = 'block';
                        document.getElementById('welcome').innerHTML = 'Welcome ' + fbname + '!';
                        document.getElementById('welcome').innerHTML = 'Welcome <a href="profile.php?username=' + fbname + '">' + fbname + '!';
                        document.getElementById('loginLinks').style.display = 'none';
                        document.getElementById('logoutLink').style.display = 'block';
                        init_fbusr_session(uid, name);
                    });
                } else {
                    $('#loginLinks').css('display', 'block');
                    $('#logoutLink').css('display', 'none');
                }
            });
        });
    });
});i
*/

$(function() {
    $('#submitLogin').click(function() {
        var username = document.getElementById('loginUsername').value;
        var password = document.getElementById('loginPassword').value;
        var data = {
            fb: false,
            username: username,
            pass: password
        };
        $.ajax({
            type: 'POST',
            url: 'login.php',
            data: data,
            complete: function(data) {
                var response = $.parseJSON(data.responseText);
                if (response.success) {
                    document.getElementById('welcome').style.display = 'block';
                    document.getElementById('welcome').innerHTML = 'Welcome ' + response.username + '!';
                    document.getElementById('welcome').innerHTML = 'Welcome <a href="profile.php?username=' + response.username + '">' + response.username + '</a>!';
                    document.getElementById('loginLinks').style.display = 'none';
                    document.getElementById('logoutLink').style.display = 'block';
                    document.getElementById('login_popup').style.display = 'none';
                    document.getElementById('loginUsername').value = '';
                    document.getElementById('loginPassword').value = '';
                    if (response.username == "admin") {
                        $('#edit_about').css('display', 'block');
                    } else {
                        $('#edit_about').css('display', 'none');
                    }
                } else {
                    $('#login_popup').append(response.message);
                }
            }
        });
    });
});


var init_menu = function() {

    $.ajax({
        url: 'food.php',
        type: 'POST',
        contentType: 'application/json',
        dataType: 'json',
        processData: false,
        complete: function(data) {
	console.log(data);
        var response = $.parseJSON(data.responseText);
            if (response.success) {
		$.each(response["animal"], function(){
	$("#items ul").append('<li name="'+this.id+'">'+this.name+'</li><br>');
	$("#prices ul").append('<li name="'+this.id+'">$'+this.price+'</li><br>');
	});
	} 
	
	else {
	}
	}
	});
    
    $("#buy").onclick(function(e){
	var animal_id = document.getElementById("animal_id").value;
	var deleteAnimal_flag = "true";
	var dataString = "deleteEvent_flag=" + encodeURIComponent(deleteAnimal_flag) + "&animal_id=" + encodeURIComponent(animal_id);
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST",'order.php', true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
		}else{
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
    });

    $("#menu_sort").submit(function(e) {
        e.preventDefault();
        $("#items ul").empty();
        $("#prices ul").empty();
        $("#rating ul").empty();
        var cat = $("#cat").val();
        var ord = $("#sort").val();
        var data = {
            category: cat,
            order: ord
        };
        $.ajax({
            type: 'POST',
            url: 'food.php',
            data: data,
            complete: function(data) {
                var response = $.parseJSON(data.responseText);
                if (response.success) {
		
                    $.each(response.animal, function(index) {
                        $("#items ul").append('<li name="' + this.id + '">' + this.name + '</li></br>');
                        $("#prices ul").append('<li name="' + this.id + '">$' + this.price + '</li></br>');
                        $("#rating ul").append('<li name="' + this.id + '"><div class="container"><div class="empty"></div><div class="rating" style="width:' + this.rating * 100 + '%;"></div></div></li>');
			document.getElementById("animal_id").value=this.id;
		    });
                }
            }
        });
    });
    $(document).on('click', '#menu .menu li', function() {
        var item_id = $(this).attr('name');
        var data = {
            id: item_id
        };
        $(".menu li").removeClass("selected");
        $("li[name=" + item_id + "]").addClass("selected");
        $("#menu.menu li").removeClass("selected");
        $("#menu li[name=" + item_id + "]").addClass("selected");
        $.ajax({
            type: 'POST',
            url: 'food.php',
            data: data,
            complete: function(data) {
                var response = $.parseJSON(data.responseText);
                if (response.success) {
                    var item = response.animal[0];
                    $('#description').empty();
                    $('#description').html('<b>' + item.name + '</b><br> <img src="' + item.image + '"></br><br>' +item.category+'</br> <div id="rate_error" class="error"></div>' + item.desc + '<br><br><b>Comments:</b><br><div id="item_comments"></div><br> <button id="buy">Buy Now!</button>');
                    get_comments(item.id);
                }
            }
        });
    });
};

var init_order = function() {
    $.ajax({
        url: 'food.php',
        type: 'POST',
        contentType: 'application/json',
        dataType: 'json',
        processData: false,
        complete: function(data) {
            var response = $.parseJSON(data.responseText);
            if (response.success) {
                $.each(response.animal, function() {
                    $("#order_items ul").append('<li name="' + this.id + '">' + this.name + '</li></br>');
                    $("#order_prices ul").append('<li name="' + this.id + '">$' + this.price + '</li></br>');
		    document.getElementById("animal_id").value=this.id;
			 });
            } else {
                console.log(response.message);
            }
        }
    });
    $("#order_sort").submit(function(e) {
        e.preventDefault();
        $("#order_items ul").empty();
        $("#order_prices ul").empty();
        $("#order_rating ul").empty();
        var cat = $("#order_cat").val();
        var ord = $("#order_sort").val();
        var data = {
            category: cat,
            order: ord
        };
        $.ajax({
            type: 'POST',
            url: 'food.php',
            data: data,
            complete: function(data) {
                var response = $.parseJSON(data.responseText);
                if (response.success) {
                    $.each(response.animal, function(index) {
                        $("#order_items ul").append('<li name="' + this.id + '">' + this.name + '</li>');
                        $("#order_prices ul").append('<li name="' + this.id + '">$' + this.price + '</li>');
			document.getElementById("animal_id").value=this.id;
                    });
                }
            }
        });
    });
    $(document).on('click', '#order .menu li', function() {
        var item_id = $(this).attr('name');
        var data = {
            id: item_id
        };
        $.ajax({
            type: 'POST',
            url: 'food.php',
            data: data,
            complete: function(data) {
                var response = $.parseJSON(data.responseText);
                if (response.success) {
                    var item = response.animal[0];
                    $("#ordered_item ul").append('<li name="' + item.id + '">' + item.name + '</li>');
                    $("#item_cost ul").append('<li name="' + item.id + '">$' + item.price + '</li>');
                    $("#item_rm ul").append('<li class="error link" name="' + item.id + '">x</li>');
                    var total = parseFloat($("#order_subtotal").text());
                    total += parseFloat(item.price);
                    $("#order_subtotal").text(total.toFixed(2));
                }
            }
        });
    });
    $(document).on('click', '#item_rm li', function() {
        var item_id = $(this).attr('name');
        var rm_cost = $("#item_cost li[name=" + item_id + "]").first().text().replace('$', '');
        var total = parseFloat($("#order_subtotal").text());
        total -= parseFloat(rm_cost);
        $("#order_subtotal").text(total.toFixed(2));
        $("#ordered_item li[name=" + item_id + "]").first().remove();
        $("#item_cost li[name=" + item_id + "]").first().remove();
        $("#item_rm li[name=" + item_id + "]").first().remove();
    });
    $("input[name='order_type']").change(function() {
        if ($(this).val() == 'delivery') {
            $("#delivery_info").show();
            var total = parseFloat($("#order_subtotal").text());
            total += 2.00;
            $("#order_subtotal").text(total.toFixed(2));
        } else {
            $("#delivery_info").hide();
            var total = parseFloat($("#order_subtotal").text());
            total -= 2.00;
            $("#order_subtotal").text(total.toFixed(2));
        }
    });
    $("#order_form").submit(function(e) {
        e.preventDefault();
        var name = $("input[name='order_name']").val();
        var type = $("input[name='order_type']:checked").val();
        //var address = $("input[name='order_address']").val();
        var total = parseFloat($("#order_subtotal").text());
        var items = "";
        if (name == "") {
            alert("You must enter a name");
        } 
        else if (total == 0 || (type == "delivery" && total == 2)) {
            alert("You must order some food!");
        } else {
            $("#ordered_item li").each(function() {
                items += $(this).text() + ", ";
            });
            var data = {
                type: type,
                name: name,
                total: total,
                address: address,
                items: items
            };
            $.ajax({
		//console.log ("goes into order order form");
                type: 'POST',
                url: 'order.php',
                data: data,
                complete: function(data) {
		//console.log("complete function(data)");
                    var response = $.parseJSON(data.responseText);
                    if (response.success) {
                        $("input[name='order_name']").val('');
                        $("input[name='order_type']:checked").val('');
                        $("input[name='order_address']").val('');
                        $("#order_subtotal").text('0.00');
                        $("#ordered_item ul").empty();
                        $("#item_cost ul").empty();
                        $("#item_rm ul").empty();
                        $("#order_message").text(response.message);
                    } else {
                        console.log(response.message);
                    }
                }
            });
        }
    });
};
$(document).on('fbload', function() {
    $.ajax({
        type: 'POST',
        url: 'checklogin.php',
        complete: function(data) {
            var response = $.parseJSON(data.responseText);
            if (response.loggedin && !response.fb) {
                document.getElementById('welcome').style.display = 'block';
                document.getElementById('welcome').innerHTML = 'Welcome ' + response.username + '!';
                document.getElementById('welcome').innerHTML = 'Welcome <a href="profile.php?username=' + response.username + '">' + response.username + '</a>!';
                document.getElementById('loginLinks').style.display = 'none';
                document.getElementById('logoutLink').style.display = 'block';
                document.getElementById('login_popup').style.display = 'none';
                document.getElementById('loginUsername').value = '';
                document.getElementById('loginPassword').value = '';
                if (response.username == "admin") {
                    $('#edit_about').css('display', 'block');
                } else {
                    $('#edit_about').css('display', 'none');
                }
                return;
            } else {
                FB.getLoginStatus(function(response) {
                    if (response.status === 'connected') {
                        var uid = response.authResponse.userID;
                        var accessToken = response.authResponse.accessToken;
                        var fburl = 'http://graph.facebook.com/' + uid;
                        $.getJSON(fburl, function(data) {
                            var fbname = data.first_name;
                            $('#welcome').html('Welcome ' + fbname + '!');
                            $('#loginLinks').css('display', 'none');
                            $('#logoutLink').css('display', 'block');
                        });
                    } else {
                        $('#loginLinks').css('display', 'block');
                        $('#logoutLink').css('display', 'none');
                    }
                });
            }
        }
    });
});
$(function() {
    $("#logoutLink").click(function() {
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                FB.logout(function(response) {
                    $('#welcome').html('');
                    $('#welcome').css('display', 'none');
                    $('#loginLinks').css('display', 'block');
                    $('#logoutLink').css('display', 'none');
                    $('#edit_about').css('display', 'none');
                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: 'logout.php',
                    dataType: 'json',
                    complete: function(data) {
                        if (data.success) {
                            $('#welcome').html('');
                            $('#welcome').css('display', 'none');
                            $('#loginLinks').css('display', 'block');
                            $('#logoutLink').css('display', 'none');
                            $('#edit_about').css('display', 'none');
                        }
                    }
                });
            }
        });
    });
});
$(function() {
    $("#edit_pic").click(function() {
        $.get("uploadpicture.php");
    });
});
$(function() {
    $('#edit_about').click(function() {
        $('#edit_about-us').css('display', 'block');
        var oldText = $('#about-us').html();
        $('#new_about').html(oldText);
    });
});
$(function() {
    $('#submit_about').click(function() {
        var newText = document.getElementById('new_about').value;
        var data = {
            text: newText
        };
        $.ajax({
            type: 'POST',
            url: 'update_about.php',
            data: data,
            complete: function(data) {
                var response = $.parseJSON(data.responseText);
                if (response.success) {
                    $('#about-us').html(response.text);
                    $('#new_about').html(response.text);
                    $('#edit_about-us').css('display', 'none');
                } else {
                    alert(response.message);
                    $('#edit_about-us').css('display', 'none');
                }
            }
        });
    });
});
$(function() {
    $(document).on('click', '.edit_menu_btn', function() {
        var item_id = $(this).attr('id');
        $('#submit_menu_edit').attr('name', item_id);
        var data = {
            id: item_id
        };
        $.ajax({
            type: 'POST',
            url: 'get_menu.php',
            data: data,
            complete: function(data) {
                var response = $.parseJSON(data.responseText);
                if (response.success) {
                    $('#edit_menu').css('display', 'block');
                    document.getElementById('edit_item_name').value = response.name;
                    document.getElementById('edit_item_price').value = response.price;
                }
            }
        });
    });
});
$(function() {
    $('#submit_menu_edit').click(function() {
        var newName = document.getElementById('edit_item_name').value;
        var newPrice = document.getElementById('edit_item_price').value;
        var itemId = $('#submit_menu_edit').attr('name');
        var data = {
            id: itemId,
            name: newName,
            price: newPrice
        };
        console.log(data);
        $.ajax({
            type: 'POST',
            url: 'update_menu.php',
            data: data,
            complete: function(data) {
                var response = $.parseJSON(data.responseText);
                if (response.success) {
                    $('#edit_menu').css('display', 'none');
                    $("#items ul").empty();
                    $("#prices ul").empty();
                    $("#rating ul").empty();
                    init_menu();
                } else {
                    console.log(response.message);
                }
            }
        });
    });
});
$(function() {
    $("#datepicker").datepicker();
});
$(function() {
    init_nav();
    init_login();
    init_register();
    init_menu();
    init_order();
});
