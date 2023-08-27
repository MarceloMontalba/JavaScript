//Call-Back Sincrona
// const hacerPeticion = (peticion) => {
//     console.log(`${peticion}`);
// }

// const llamarFuncion = (calback, peticion) => {
//     calback(peticion);
// }

// llamarFuncion(hacerPeticion, "Quiero un perrito, por favor!!!!!")

//Call-Back Asincrona
// const hacerPeticion = (peticion) => {
//     setTimeout( () => {
//         console.log(peticion)
//     },2000);
// }

// const llamarFuncion = (callback, peticion) => {
//     callback(peticion);
// }

// console.log("Iniciando Callback");
// llamarFuncion(hacerPeticion, "Quiero una bicicleta!!!!!!");
// console.log("Mensaje despues de la Callback");
// console.log("Termino del programa");

//Promesa
// const condicional = true;

// const promesaCondicional = new Promise((resolve, reject) => {
//     if(condicional) {
//         const auto = {
//             modelo: "Toyota Corolla",
//             year: 2005,
//             color: "Verde"
//         };
//         resolve(auto);
//     }else {
//         reject("No ha cumplido con los requisitos.");
//     }
// });

// //Succes Handler
// const requisitosCumplidos = (objetoDevuelto) => {
//     console.log(`El modelo del auto es : ${objetoDevuelto.modelo}.`);
//     console.log(`El año del auto es : ${objetoDevuelto.year}.`);
//     console.log(`El color de este auto es : ${objetoDevuelto.color}`);
// }

// //Failed Handler
// const requisitosFallidos = (respuesta) => {
//     console.log(respuesta);
// }


// promesaCondicional.then(requisitosCumplidos, requisitosFallidos);

// Promise All

const observarCalificacion = (calificacion) => {
    return new Promise((resolve, reject) => {
        if(calificacion >= 55) {
            const nuevoTelefono = {
                modelo  : "Redmi 10C",
                color   : "Rojo",
                memoria : "64GB"
            };
            resolve(nuevoTelefono);
        }else {
            reject("No te esforzaste");
        }
    });
}

const observarComportamiento = (comportamiento) => {
    return new Promise((resolve, reject) => {
        if(comportamiento) {
            const auto = {
                modelo : "Toyota Corolla",
                color:   "Blanco"
            };
            resolve(auto);
        }
        else {
            reject("Te daré unas nalgadas!!!!.");
        }
    });
}

// const desicionCalificacion = observarCalificacion(56);
// const desicionComportamiento = observarComportamiento(true);
// const promesas = [desicionCalificacion, desicionComportamiento];

// Promise.all(promesas)
//     .then((respuesta) => console.log(respuesta))
//     .catch((respuesta) => console.log(respuesta));


//Promesas anidadas
// const observarCalificacion = (calificacion) => {
//     return new Promise((resolve, reject) => {
//         if(calificacion >= 55) {
//             const nuevoTelefono = {
//                 modelo  : "Redmi 10C",
//                 color   : "Rojo",
//                 memoria : "64GB"
//             };
//             resolve(nuevoTelefono);
//         }else {
//             reject("Debes Estudiar Más.");
//         }
//     });
// }

// const observarComportamiento = (telefono, comportamiento) => {
//     return new Promise((resolve, reject) => {
//         if(comportamiento){
//             resolve(telefono);
//         }else {
//             reject("Te Daré unas Nalgadas!!!.");
//         }
//     });
// }

// observarCalificacion(55)
//     .then((respuesta) => {
//         observarComportamiento(respuesta, false)
//             .then((respuesta) => {
//                 console.log(`Felicidades te ganaste tu nuevo ${respuesta.modelo}`);
//             })
//             .catch((respuesta) => console.log(respuesta));
//     })
//     .catch((respuesta) => console.log(respuesta))

// assync await

const pideTelefonoNuevo = async (comportamiento, calificacion) => {
    try {
        const promesas = await Promise.all([observarComportamiento(comportamiento),
                                      observarCalificacion(calificacion)]);
        console.log(promesas);
    }catch(error){
        console.log(error);
    }
}

console.log("Mensaje de Inicio");
pideTelefonoNuevo(true, 90);
console.log("Mensaje Final");