		<style>
		#myBtn {
		  display: none;
		  position: fixed;
		  bottom: 20px;
		  right: 30px;
		  z-index: 99;
		  border: none;
		  outline: none;
		  background-color: red;
		  color: white;
		  cursor: pointer;
		  padding: 9px;
		border-radius: 50%;
		font-size: 35px;
		  box-shadow: 1px 1px 6px black;
		}

		#myBtn:hover {
		  background-color: #555;
		}
		</style>
		
		
		<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i></button>
		<script>
		// When the user scrolls down 20px from the top of the document, show the button
		var elem;
		
		function setElemScroll(input){
			elem = input;
		}
		window.onscroll = function() {scrollFunction()};

		function scrollFunction() {
			if (elem.scrollTop > 20) {
				document.getElementById("myBtn").style.display = "block";
			} else {
				document.getElementById("myBtn").style.display = "none";
			}
		}

		// When the user clicks on the button, scroll to the top of the document
		function topFunction() {
			elem.scrollTop = 0;
		}
		</script>