<!-- Bootstrap and Three.js -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/threed.css') }}">
<script src="{{ asset('js/custom3d.js') }}?v={{ time() }}"></script>
<script async src="https://unpkg.com/es-module-shims@1.3.6/dist/es-module-shims.js"></script>
		<script type="importmap">
		  {
			"imports": {
			  "three": "https://unpkg.com/three@0.138.0/build/three.module.js",
			  "three/addons/": "https://unpkg.com/three@0.138.0/examples/jsm/"
			}
		  }
		</script>

		<script src='https://unpkg.co/gsap@3/dist/gsap.min.js'></script>
		<script src='https://unpkg.co/gsap@3/dist/ScrollTrigger.min.js'></script>
<script>document.documentElement.className="js";var supportsCssVars=function(){var e,t=document.createElement("style");return t.innerHTML="root: { --tmp-var: bold; }",document.head.appendChild(t),e=!!(window.CSS&&window.CSS.supports&&window.CSS.supports("font-weight","var(--tmp-var)")),t.parentNode.removeChild(t),e};supportsCssVars()||alert("Please view this demo in a modern browser that supports CSS Variables.");</script>

<!-- Customize Modal -->
<div class="modal fade" id="customizeModal" tabindex="-1" aria-labelledby="customizeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customizeModalLabel">Customize Your Box</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex">
                <!-- 3D Canvas (Left Side) -->
                <div id="threeCanvas" class="canvas-container" style="width: 50%; height: 500px;">
                    <div class="content">
                        <div class="page3d">
                            <div class="container3d">
                                <canvas id="box-canvas"></canvas>
                                <div class="ui-controls">
                                    <button class="unbutton ui-controls__button" id="zoom-in" aria-label="Zoom in">+</button>
                                    <button class="unbutton ui-controls__button" id="zoom-out" aria-label="Zoom out">-</button>
                                    <div>Scroll to animate</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customization Panel (Right Side) -->
                <div class="customization-container">
                    <div class="button-group">
                        <button class="btn upload">Upload</button>
                        <button class="btn reset">Reset</button>
                        <button class="btn rotate">Rotate</button>
                    </div>
                    
                    <div class="button-group">
                        <button class="btn">Front</button>
                        <button class="btn">Left</button>
                        <button class="btn">Back</button>
                        <button class="btn">Right</button>
                        <button class="btn">Top</button>
                        <button class="btn">Bottom</button>
                    </div>
                    
                    <input type="text" class="text-input" placeholder="Add your text here">
                    
                    <div class="dropdown-group">
                        <label for="fontStyle"><u>Add more text</u></label>
                        <select id="fontStyle" class="dropdown">
                            <option value="Decorative">Decorative</option>
                        </select>
                        <select id="fontSize" class="dropdown">
                            <option value="20px">20px</option>
                        </select>
                    </div>
                    
                    <div class="printing-options">
                        <p>Choose your Printing type</p>
                        <div class="options-container">
                            <div class="option flexo">
                                <input type="radio" id="flexo" name="printType">
                                <label for="flexo">Flexo</label>
                                <ul>
                                    <li>1 Colour: No Bleed</li>
                                    <li>Basic Graphics</li>
                                    <li>3 Days</li>
                                    <li>Min Qty: 100</li>
                                </ul>
                                <div class="ink-colour-selector" style="display: none;">
                                    <p>Ink Colour:</p>
                                    <select id="inkColour">
                                        <option value="">-- Please Select --</option>
                                        <option value="black">Black</option>
                                        <option value="blue">Blue</option>
                                        <option value="red">Red</option>
                                        <option value="green">Green</option>
                                        <option value="white">White</option>
                                        <option value="silver">Metallic Silver</option>
                                        <option value="gold">Metallic Gold</option>
                                        <option value="two-colour">Two Colour (email us)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="option offset">
                                <input type="radio" id="offset" name="printType" checked>
                                <label for="offset">Offset</label>
                                <ul>
                                    <li>Full Bleed CMYK</li>
                                    <li>Multicolour Graphics</li>
                                    <li>10 Days</li>
                                    <li>Min Qty: 1000</li>
                                </ul>
                                <p class="setup-charge">Setup Charge: <span class="price">7999</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="image-preview">
                        <img src="{{ asset('images/flexo_image.png') }}" alt="Flexo Printing" width="430px" height="150px">
                    </div>
                    
                    <div class="pricing">
                        <span class="quantity">3000</span>
                        <span class="price">₹12.44</span>
                        <button class="btn add-to-cart">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const options = document.querySelectorAll(".option");
    const flexoRadio = document.getElementById("flexo");
    const inkSelector = document.querySelector(".ink-colour-selector");

    options.forEach(option => {
        option.addEventListener("click", function () {
            // Remove 'selected' class from all options
            options.forEach(opt => opt.classList.remove("selected"));

            // Add 'selected' class to the clicked option
            this.classList.add("selected");
        });
    });

    flexoRadio.addEventListener("change", function () {
        if (flexoRadio.checked) {
            inkSelector.style.display = "block";
        }
    });

    document.getElementById("offset").addEventListener("change", function () {
        inkSelector.style.display = "none";
    });
});

</script>
<style>

.option {
    padding: 10px;
    border: 2px solid transparent; /* Default border */
    transition: border-color 0.3s ease-in-out;
}

.option.selected {
    border-color: green; /* Green border when selected */
}

.ink-colour-selector {
    margin-top: 10px;
}

.ink-colour-selector select {
    width: 100%;
    padding: 5px;
}

.printing-options {
    font-family: Arial, sans-serif;
}

.options-container {
    display: flex;
    gap: 20px; /* Adds space between the two options */
}

.option {
    width: 48%;
    border: 2px solid #ccc;
    padding: 15px;
    border-radius: 10px;
    transition: border-color 0.3s;
    background: #fff;
}

.option input[type="radio"] {
    margin-right: 10px;
}

.option label {
    font-weight: bold;
    font-size: 18px;
    display: block;
    margin-bottom: 10px;
}

/* Bullet points for all <li> */
.option ul {
    list-style-type: disc;
    padding-left: 20px;
    color: black;
}

.option ul li {
    margin-bottom: 5px;
    list-style-type: disc;
    padding-left: 20px;
    color: black;
}

/* Highlight border when selected */
.option input[type="radio"]:checked + label {
    color: #007bff;
}

.option input[type="radio"]:checked + label + ul,
.option input[type="radio"]:checked + label + p {
    border-color: #007bff;
}

.option input[type="radio"]:checked ~ .option {
    border: 2px solid #007bff;
}

/* Setup Charge Styling */
.setup-charge {
    font-weight: bold;
    color: green;
    margin-top: 10px;
}

.price {
    font-size: 18px;
    font-weight: bold;
}

.customization-container {
    font-family: Arial, sans-serif;
    padding: 20px;
    background-color: #f8f5f1;
}
.button-group {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}
.btn {
    padding: 10px;
    border: none;
    cursor: pointer;
    background-color: #e0e0e0;
    border-radius: 5px;
}
.text-input {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
}
.dropdown-group {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}
.dropdown {
    padding: 5px;
}

.setup-charge {
    color: green;
    font-weight: bold;
}
.image-preview {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}
.image p {
    font-weight: bold;
    text-align: center;
}
.vs {
    font-size: 20px;
    font-weight: bold;
    color: red;
}
.pricing {
    display: flex;
    align-items: center;
    gap: 10px;
}
.quantity {
    font-size: 18px;
}
.price {
    color: orange;
    font-size: 18px;
    font-weight: bold;
}
.add-to-cart {
    background-color: blue;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
}
</style>