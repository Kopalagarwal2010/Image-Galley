const apiKey = "fugvL9LWViqouQwchgppGO0eKK7Ruq0GfGOZUOzWgacuFEZ0QNHD2jAu";
const perPage = 15;
let currentPage = 1;
let searched = null;

const imageWrapper = document.querySelector(".images");
const loadBtn = document.querySelector(".loader"); 
const searchInput = document.querySelector(".search-box input");
const focusBox = document.querySelector(".focusBox");
const previewImg = document.querySelector(".preview-img");
const closePreview = document.querySelector(".close");
const downloadPreview = document.querySelector(".download");
const loginButton = document.getElementById("showLoginFormBtn"); // Button to open the login form
const loginFormContainer = document.getElementById("loginFormContainer"); // Login form container
const loginFormClose = document.querySelector(".close-login-form"); // Optional: Add a close button in the login form

const downloadImage = (imgURL) => {
    fetch(imgURL).then(res => res.blob()).then(file => {
        const a = document.createElement("a");
        a.href = URL.createObjectURL(file);
        a.download = new Date().getTime();
        a.click();
    }).catch(() => alert("Failed to download the image"));
}

const showPreview = (image, _photographer) => {
    focusBox.classList.add("show");
    focusBox.querySelector("span").innerText = _photographer;
    focusBox.querySelector("img").src = image;
    downloadPreview.setAttribute("data-img", img);
    document.body.style.overflow = "hidden";
}

const closePreviewImg = () => {
    focusBox.classList.remove("show");
    document.body.style.overflow = "auto";
}

const generateHTML = (images) => {
    imageWrapper.innerHTML +=  images.map(img => `
        <li class="card" onclick="showPreview('${img.src.large2x}', '${img.photographer}')">
            <img src="${img.src.large2x}" alt="image">
            <div class="details">
                <div class="image-provider">
                    <i class="fa-solid fa-camera"></i>
                    <span>${img.photographer}</span>
                </div>
                <button onclick="downloadImage('${img.src.large2x}')">
                    <i class="fa-solid fa-download"></i>
                </button>
            </div> 
        </li>`
    ).join("");
}

const getImages = (apiUrl) => {
    loadBtn.innerText = "Loading...";
    loadBtn.classList.add("disabled");
    fetch(apiUrl, {
        headers: {Authorization: apiKey}
    }).then(res => res.json()).then(data => {
        generateHTML(data.photos);
        loadBtn.innerText = "Load More";
        loadBtn.classList.remove("disabled");
    }).catch(() => {
        alert("Failed to load images");
        window.location.reload();  
    });
}

const loadImages = () => {
    currentPage++;
    let apiUrl = `https://api.pexels.com/v1/curated?page=${currentPage}&per_page=${perPage}`;
    if(searched) {
        apiUrl = `https://api.pexels.com/v1/search?query=${searched}&page=${currentPage}&per_page=${perPage}`;
    }
    getImages(apiUrl);
}

const searchImages = (e) => {
    if (e.target.value === "") {
        searched = null;
    }
    if (e.key === "Enter") {
        searched = e.target.value;
        currentPage = 1;
        imageWrapper.innerHTML = "";
        let apiUrl = `https://api.pexels.com/v1/search?query=${searched}&page=${currentPage}&per_page=${perPage}`;
        getImages(apiUrl);
    }
}

// Load initial set of images
getImages(`https://api.pexels.com/v1/curated?page=${currentPage}&per_page=${perPage}`);

// Event Listeners
loadBtn.addEventListener("click", loadImages);
searchInput.addEventListener("keyup", searchImages);
closePreview.addEventListener("click", closePreviewImg);
downloadPreview.addEventListener("click", (e) => downloadImage(e.target.dataset.img));

// JavaScript to handle the overlay visibility and blur effect
document.getElementById('openSignup').addEventListener('click', function () {
    const overlay = document.getElementById('signupOverlay');
    const body = document.querySelector('body');
    
    // Show the overlay and blur the background
    overlay.classList.remove('hidden');
    body.classList.add('blurred');
});

// Optional: Close overlay when clicking outside the form (optional)
document.getElementById('signupOverlay').addEventListener('click', function (e) {
    if (e.target === this) {
        this.classList.add('hidden');
        document.querySelector('body').classList.remove('blurred');
    }
});

// Show the login form when the button is clicked
loginButton.addEventListener("click", () => {
    loginFormContainer.classList.add("show-form"); // Adds the class to display the form
    document.body.style.overflow = "hidden"; // Prevent scrolling in the background
});

document.getElementById('signupOverlay').addEventListener('click', function (e) {
    if (e.target === this) {
        this.classList.add('hidden');
        document.querySelector('body').classList.remove('blurred');
    }
});

// Function to close form when clicking outside of it (for signup form)
document.getElementById('signupOverlay').addEventListener('click', function (e) {
    if (e.target === this) {
        this.classList.add('hidden');
        document.querySelector('body').classList.remove('blurred');
    }
});

// Function to close login form when clicking outside of it (for login form)
document.getElementById('loginFormContainer').addEventListener('click', function (e) {
    if (e.target === this) {
        this.classList.remove('show-form');
        document.body.style.overflow = "auto"; // Restore scrolling
    }
});

// JavaScript to open/close signup and login forms
document.getElementById('openSignup').addEventListener('click', function() {
    document.getElementById('signupOverlay').classList.remove('hidden');
    document.getElementById('loginFormContainer').classList.add('hidden');
});

document.getElementById('showLoginFormBtn').addEventListener('click', function() {
    document.getElementById('loginFormContainer').classList.remove('hidden');
    document.getElementById('signupOverlay').classList.add('hidden');
});

// Close the signup form when the user clicks outside of it (optional)
document.querySelector('.overlay').addEventListener('click', function(e) {
    if (e.target === this) {
        document.getElementById('signupOverlay').classList.add('hidden');
    }
});

