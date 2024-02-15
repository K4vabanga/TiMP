let copyBlock = 1
let key = '4856495248564854'

function encryption(pswrd) {
// преобразуем строку в массив символов, вызывая метод split и передавая ему пустую строку
	let strArray = pswrd.split('')
// проходимся по каждому элементу массива, преобразуем символ в его числовой код
// и выполняем простейшее XOR шифрование
	let crypted = strArray.map(value => value.charCodeAt(0) ^ 1).join('')
	return crypted
}

function noselect() {
	return false
}

function select() {
	return true
}

function Blocker(copyBlock) {
	if (copyBlock == 1) {
		document.ondragstart = noselect
		document.onselectstart = noselect
		document.oncontextmenu = noselect
	}
	else if (copyBlock == 0) {
		document.ondragstart = select
		document.onselectstart = select
		document.oncontextmenu = select
	}
}
Blocker(copyBlock)

document.addEventListener('contextmenu', function(event) {
	if (copyBlock == 1) {
		let pswrd = prompt('Введите пароль', '')
		if (encryption(pswrd) == key) {
			alert("Успешно!")
			copyBlock = 0
			Blocker(copyBlock)
			
		}
		else if (encryption(pswrd) != key && pswrd != null) {
			alert("Неверный пароль!")
		}
	}
})
