const steps = document.querySelectorAll(".stp");
const circleSteps = document.querySelectorAll(".step");
const formInputs = document.querySelectorAll(".step-1 .form-validate");
const formInputs2 = document.querySelectorAll(".step-2 .form-validate");
const formInputs3 = document.querySelectorAll(".step-3 .form-validate");
const formInputs4 = document.querySelectorAll(".step-4 .form-validate");
const formInputs5 = document.querySelectorAll(".step-5 .form-validate");
const formInputs6 = document.querySelectorAll(".step-6 .form-validate");
const formInputs7 = document.querySelectorAll(".step-7 .form-validate");
const formInputs8 = document.querySelectorAll(".step-8 .form-validate");

const stepInputs = [];
stepInputs.push(formInputs); //id 0
stepInputs.push(formInputs2); //id 1
stepInputs.push(formInputs3); //id 2
stepInputs.push(formInputs4); //id 3
stepInputs.push(formInputs5); //id 4
stepInputs.push(formInputs6); //id 5
stepInputs.push(formInputs7); //id 6
stepInputs.push(formInputs8); //id 7

let currentStep = 1;
let currentCircle = 0;

circleSteps.forEach((circleStep) => {
	circleStep.addEventListener("click", () => {
		const stepNumber = circleStep.dataset.step;
		if (!validateForm(stepInputs[stepNumber - 1])) {
			return;
		}
		document.querySelector(`.step-${currentStep}`).style.display = "none";
		currentStep = stepNumber;
		document.querySelector(`.step-${stepNumber}`).style.display = "flex";
		for (let i = 6; i >= stepNumber; i--) {
			circleSteps[i].classList.remove("active");
		}
		for (let i = 0; i < stepNumber; i++) {
			circleSteps[i].classList.add("active");
		}
	});
});
const sendBtn = document.getElementById("send-button");
const studentForm = document.getElementById("uczniowie-form");

if (sendBtn) {
	sendBtn.addEventListener("click", () => {
		if (validateForm(stepInputs[currentStep - 1])) {
			studentForm.submit();
		}
	});
}
steps.forEach((step) => {
	const nextBtn = step.querySelector(".next-stp");
	const prevBtn = step.querySelector(".prev-stp");

	if (prevBtn) {
		prevBtn.addEventListener("click", () => {
			document.querySelector(`.step-${currentStep}`).style.display = "none";
			currentStep--;
			document.querySelector(`.step-${currentStep}`).style.display = "flex";
			circleSteps[currentCircle].classList.remove("active");
			currentCircle--;
		});
	}
	if (nextBtn) {
		nextBtn.addEventListener("click", () => {
			// console.log(currentStep);
			//Chowamy aktualny krok (formularz)
			document.querySelector(`.step-${currentStep}`).style.display = "none";
			if (currentStep < 7 && validateForm(stepInputs[currentStep - 1])) {
				currentStep++;
				currentCircle++;
			}
			document.querySelector(`.step-${currentStep}`).style.display = "flex";
			circleSteps[currentCircle].classList.add("active");
		});
	}
});

function clickOnSidebarCircle() {
	document.querySelector(`.step-${currentStep}`).style.display = "none";
	if (currentStep < 7 && validateForm(stepInputs[currentStep - 1])) {
		currentStep++;
		currentCircle++;
	}
	document.querySelector(`.step-${currentStep}`).style.display = "flex";
	circleSteps[currentCircle].classList.add("active");
}

function validateForm(currentFormInputs) {
	const fieldsNumber = currentFormInputs.length;
	let validFields = 0;
	for (let i = 0; i < currentFormInputs.length; i++) {
		console.log(currentFormInputs[i]);
		if (!currentFormInputs[i].value) {
			currentFormInputs[i].classList.add("err");
			findLabel(currentFormInputs[i]).nextElementSibling.style.display = "flex";
		} else {
			//TODO Kolejne funkcje do walidacji kodu / telefonu itp
			if ( currentFormInputs[i].id == "email" ) {
				if (validateEmail(currentFormInputs[i].value)) {
					validFields++;
					currentFormInputs[i].classList.remove("err");
					findLabel(currentFormInputs[i]).nextElementSibling.style.display =
						"none";
				} else {
					currentFormInputs[i].classList.add("err");
					findLabel(currentFormInputs[i]).nextElementSibling.textContent =
						"Email nie jest poprawny.";
					findLabel(currentFormInputs[i]).nextElementSibling.style.display =
						"flex";
				}
            } else if (currentFormInputs[i].id == "email2") {
				if (validateEmail2(currentFormInputs[i].value)) {
					validFields++;
					currentFormInputs[i].classList.remove("err");
					findLabel(currentFormInputs[i]).nextElementSibling.style.display =
						"none";
				} else {
					currentFormInputs[i].classList.add("err");
					findLabel(currentFormInputs[i]).nextElementSibling.textContent =
						"Email nie jest poprawny.";
					findLabel(currentFormInputs[i]).nextElementSibling.style.display =
						"flex";
				}
			} else if (
                        currentFormInputs[i].id == "pesel" ||
                        currentFormInputs[i].id == "motherPesel"
                    ) {
				if (validatePesel(currentFormInputs[i].value)) {
					validFields++;
					currentFormInputs[i].classList.remove("err");
					findLabel(currentFormInputs[i]).nextElementSibling.style.display =
						"none";
				} else {
					currentFormInputs[i].classList.add("err");
					findLabel(currentFormInputs[i]).nextElementSibling.textContent =
						"Pesel nie jest poprawny.";
					findLabel(currentFormInputs[i]).nextElementSibling.style.display =
						"flex";
				}
			} else if (currentFormInputs[i].id == "postcode") {
				if (validatePostCode(currentFormInputs[i].value)) {
					validFields++;
					currentFormInputs[i].classList.remove("err");
					findLabel(currentFormInputs[i]).nextElementSibling.style.display =
						"none";
				} else {
					currentFormInputs[i].classList.add("err");
					findLabel(currentFormInputs[i]).nextElementSibling.textContent =
						"Kod pocztowy nie jest poprawny.";
					findLabel(currentFormInputs[i]).nextElementSibling.style.display =
						"flex";
				}
			} else if (
				currentFormInputs[i].id == "phone" ||
				currentFormInputs[i].id == "phone2" ||
                currentFormInputs[i].id == "motherPhone"
			) {
				if (validatePhone(currentFormInputs[i].value)) {
					validFields++;
					currentFormInputs[i].classList.remove("err");
					findLabel(currentFormInputs[i]).nextElementSibling.style.display =
						"none";
				} else {
					currentFormInputs[i].classList.add("err");
					findLabel(currentFormInputs[i]).nextElementSibling.textContent =
						"Numer telefonu nie jest poprawny.";
					findLabel(currentFormInputs[i]).nextElementSibling.style.display =
						"flex";
				}
			} else if (
				currentFormInputs[i].id == "studia" ||
				currentFormInputs[i].id == "tshirt" ||
				currentFormInputs[i].id == "wspolnota"
			) {
				if (validatePlec(currentFormInputs[i].value)) {
					validFields++;
					currentFormInputs[i].classList.remove("err");
					findLabel(currentFormInputs[i]).nextElementSibling.style.display =
						"none";
				} else {
					currentFormInputs[i].classList.add("err");
					findLabel(currentFormInputs[i]).nextElementSibling.textContent =
						"Wybierz pole";
					findLabel(currentFormInputs[i]).nextElementSibling.style.display =
						"flex";
				}
			} else if (currentFormInputs[i].type == "checkbox") {
				console.log("checkboxy");
				//TODO validacja checkboxów
				if (validateCheckbox(currentFormInputs[i])) {
					validFields++;
					currentFormInputs[i].classList.remove("err");
					currentFormInputs[i].previousElementSibling.style.display = "none";
				} else {
					currentFormInputs[i].classList.add("err");
					console.log(currentFormInputs[i].previousElementSibling);
					currentFormInputs[i].previousElementSibling.textContent =
						"Nie zaznaczono";
					currentFormInputs[i].previousElementSibling.style.display = "flex";
				}
			} else {
				validFields++;
				currentFormInputs[i].classList.remove("err");
				findLabel(currentFormInputs[i]).nextElementSibling.style.display =
					"none";
			}
		}
	}
	if (validFields == fieldsNumber) {
		return true;
	} else {
		return false;
	}
}
function validatePostCode(value) {
	var regex = /^[0-9]{2}-[0-9]{3}/;
	return regex.test(value);
}

function validatePhone(value) {
	var regex = /^[0-9]{9}$/;
	return regex.test(value);
}

function validateCheckbox(field) {
	if (field.checked) {
		return true;
	}
	return false;
}

function validatePesel(pesel) {
	var regex = /^[0-9]{11}$/;
	return regex.test(pesel);
}

function validatePlec(value) {
	if (value == "") {
		return false;
	}
	return true;
}

function validateEmail(value) {
	console.log(value);
	var regex =
		/^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@dzielo.pl/;
	return regex.test(value);
}

function validateEmail2(value) {
	console.log(value);
	var regex =
		/^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
	return regex.test(value);
}


function findLabel(el) {
	const idVal = el.id;
	const labels = document.getElementsByTagName("label");
	for (let i = 0; i < labels.length; i++) {
		if (labels[i].htmlFor == idVal) return labels[i];
	}
}

// wybierz plik

$("#chooseFile").bind("change", function () {
	var filename = $("#chooseFile").val();
	if (/^\s*$/.test(filename)) {
		$(".file-upload").removeClass("active");
		$("#noFile").text("Nie wybrano pliku...");
	} else {
		$(".file-upload").addClass("active");
		$("#noFile").text(filename.replace("C:\\fakepath\\", ""));
	}
});




const el = document.getElementById('job');
const box = document.getElementById('hide1');
const box2 = document.getElementById('hide2');
const box3 = document.getElementById('hide3');
const box4 = document.getElementById('hide4');
const box5 = document.getElementById('hide5')

if (el) {
	el.addEventListener('change', function handleChange(event) {
		if (event.target.value === 'Student') {
			box.style.display = 'block';
			box2.style.display = 'block';
			box3.style.display = 'block';
			box4.style.display = 'none';
			box5.style.display = 'none';
		}
		if (event.target.value === 'Osoba pracująca') {
			box4.style.display = 'block';
			box5.style.display = 'block';
			box.style.display = 'none';
			box2.style.display = 'none';
			box3.style.display = 'none';
		}
		if (event.target.value === 'Maturzysta') {
			box4.style.display = 'none';
			box5.style.display = 'none';
			box.style.display = 'none';
			box2.style.display = 'none';
			box3.style.display = 'none';
		}
		if (event.target.value === '') {
			box4.style.display = 'none';
			box5.style.display = 'none';
			box.style.display = 'none';
			box2.style.display = 'none';
			box3.style.display = 'none';
		}
	});
}


const szczepieniaInne = document.getElementById("szczepieniaInne");
const szczepieniaInneInput = document.getElementById("szczepieniaInneInput");


const dieta = document.getElementById("dieta");
const dietaInfo = document.getElementById("ukryj");
const jakaDieta = document.getElementById("ukryj1");

if (dieta) {
	dieta.addEventListener("change", function handleChange(event) {
		if (event.target.value === "TAK") {
			dietaInfo.style.display = "block";
			jakaDieta.style.display = "block";
			const element1 = document.getElementById("jakaDieta");
			element1.classList.add("form-validate");
		}
		if (event.target.value === "NIE") {
			dietaInfo.style.display = "none";
			jakaDieta.style.display = "none";
			const element1 = document.getElementById("jakaDieta");
			element1.classList.remove("form-validate");
		}
		if (event.target.value === "Wybierz") {
			dietaInfo.style.display = "none";
			jakaDieta.style.display = "none";
			element1.classList.remove("form-validate");
		}

		//Wspolna dla wszystkich
		const formInputs5 = document.querySelectorAll(".step-5 .form-validate");
		stepInputs[4] = formInputs5;
	});
}

if (szczepieniaInne) {
	szczepieniaInne.addEventListener("change", function handleChange(event) {
		if(event.target.checked) {
			szczepieniaInneInput.style.display = "block";
		} else {
			szczepieniaInneInput.style.display = "none";
		}
	});
}





