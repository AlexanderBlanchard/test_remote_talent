<template>
    <div class="user-profile card">
        <div class="card-image text-center py-4">
            <img :src="imagen" alt="User Image" class="card-img-top rounded-circle" @error="imageErrorHandler" />
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ nombre }} {{ apellidos }}</h5>
            <p class="card-text">
                <span class="mdi mdi-phone"></span> {{ telefono }}
            </p>
            <p class="card-text">
                <span class="mdi mdi-email"></span> {{ correo }}
            </p>
        </div>
    </div>
    <div class="back-button-container">
        <router-link to="/" class="btn btn-primary">Regresar al inicio</router-link>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            defaultNombre: "No especificado",
            defaultApellidos: "No especificado",
            defaultTelefono: "No especificado",
            defaultCorreo: "No especificado",
            defaultImagen: require('@/assets/default_avatar_image.png')
        };
    }
    ,
    computed: {
        nombre() {
            return this.$route.query.nombre || this.defaultNombre;
        },
        apellidos() {
            return this.$route.query.apellidos || this.defaultApellidos;
        },
        telefono() {
            return this.$route.query.telefono || this.defaultTelefono;
        },
        correo() {
            return this.$route.query.correo || this.defaultCorreo;
        },
        imagen() {
            return this.$route.query.imagen || this.defaultImagen;
        }
    }
    ,
    created() {
        this.sendDataToAPI();
    },
    methods: {
        imageErrorHandler(event) {
            event.target.src = require('@/assets/no-image.png')
        },

        sendDataToAPI() {
            axios.post('http://localhost:8001/api/procesar-informacion', {
                nombre: this.nombre,
                apellidos: this.apellidos,
                telefono: this.telefono,
                correo: this.correo,
                imagen: this.imagen
            })
                .then(response => {
                    console.log(response);
                    console.log("Datos procesados con éxito");
                })
                .catch(error => {
                    console.error("Hubo un error al enviar los datos", error);
                });
        }
    }
};
</script>
  

<style scoped>
.user-profile {
    max-width: 350px;
    margin: 40px auto;
    border: none;
    background-color: #f7f7f7;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

.card-image {
    padding: 30px;
    background-color: lightskyblue;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    text-align: center;
}

.card-body {
    padding: 20px;
    text-align: center;
}

.card-title {
    margin-bottom: 10px;
    color: #333;
}

.card-text {
    color: #666;
    gap: 5px;
}

img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.user-profile .card {
    max-width: 400px;
    margin: 20px auto;
}

.card-image img {
    width: 140px;
    height: 140px;
}

.card-body .card-title {
    font-weight: bold;
}

.back-button-container {
    margin-top: 2em;
    text-align: center;
}
</style>