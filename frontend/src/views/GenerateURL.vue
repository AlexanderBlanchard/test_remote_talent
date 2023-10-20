<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1 class="mb-4 text-center">Generate URL Page</h1>
                        <form @submit.prevent="generateURL">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-account"></i></span>
                                </div>
                                <input id="nombre" v-model="nombre" type="text" class="form-control"
                                    placeholder="Ingresa tu nombre" :disabled="isCompleted" maxlength="50">
                                <div v-if="formErrors.nombre" class="text-danger">{{ formErrors.nombre[0] }}</div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-account-multiple"></i></span>
                                </div>
                                <input id="apellidos" v-model="apellidos" type="text" class="form-control"
                                    placeholder="Ingresa tus apellidos" :disabled="isCompleted" maxlength="50">
                                <div v-if="formErrors.apellidos" class="text-danger">{{ formErrors.apellidos[0] }}</div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-phone"></i></span>
                                </div>
                                <input id="telefono" v-model="telefono" type="tel" class="form-control"
                                    placeholder="Ingresa tu teléfono" :disabled="isCompleted" maxlength="20">
                                <div v-if="formErrors.telefono" class="text-danger">{{ formErrors.telefono[0] }}</div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                                </div>
                                <input id="correo" v-model="correo" type="email" class="form-control"
                                    placeholder="Ingresa tu correo" :disabled="isCompleted">
                                <div v-if="formErrors.correo" class="text-danger">{{ formErrors.correo[0] }}</div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-image"></i></span>
                                </div>
                                <input id="imagen" type="file" class="form-control" @change="uploadImage"
                                    :disabled="isCompleted">
                                <div v-if="formErrors.image" class="text-danger">{{ formErrors.image[0] }}</div>
                            </div>
                            <div v-if="isUploadingImage" class="text-center my-3">
                                <div class="spinner-border" role="status"></div>
                            </div>
                            <button :disabled="isProcessing || isUploadingImage" type="submit"
                                class="btn btn-success btn-block">
                                <span v-if="isProcessing">Procesando datos...</span>
                                <span v-else>Generar URL</span>
                            </button>
                        </form>
                        <p v-if="responseSuccess" class="mt-3 text-success text-center">URL generada con éxito: <a
                                :href="generatedURL" target="_blank">{{ generatedURL }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
import axios from 'axios';

export default {
    name: 'GenerateURL',
    data() {
        return {
            nombre: '',
            apellidos: '',
            telefono: '',
            correo: '',
            imagen: '',
            responseSuccess: false,
            generatedURL: '',
            isUploadingImage: false,
            isProcessing: false,
            isCompleted: false,
            formErrors: {}
        };
    },
    methods: {
        async generateURL() {
            this.isProcessing = true;
            try {
                const response = await axios.post('http://localhost:8001/api/procesar-informacion', {
                    nombre: this.nombre,
                    apellidos: this.apellidos,
                    telefono: this.telefono,
                    correo: this.correo,
                    imagen: this.imagen
                });
                const data = response.data;
                this.responseSuccess = data.success;

                if (this.responseSuccess) {
                    this.isCompleted = true;
                }
                this.generatedURL = data.url;

            } catch (error) {
                console.error("Error generating URL:", error);
                if (error.response && error.response.status === 422) {
                    this.formErrors = error.response.data.errors;
                }
            }
            finally {
                this.isProcessing = false;
            }
        },
        async uploadImage(event) {
            this.isUploadingImage = true;
            const file = event.target.files[0];
            if (file) {
                const formData = new FormData();
                formData.append('image', file);

                try {
                    const response = await axios.post('http://localhost:8001/api/upload-image', formData);
                    const data = response.data;
                    if (data.success) {
                        this.imagen = data.imageUrl;
                    }
                } catch (error) {
                    console.error("Error uploading image:", error);
                    if (error.response && error.response.status === 422) {
                        this.formErrors = error.response.data.errors;
                    }
                }
                finally {
                    this.isUploadingImage = false;
                }
            }
        }
    }
};
</script>

<style scoped>
.container {
    font-family: 'Arial', sans-serif;
}

.card {
    border-radius: 1em;
    overflow: hidden;
}

.card-body {
    padding: 2em;
}

h1.text-center {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 1em;
    color: #0056b3;
    border-bottom: 2px solid #e0e0e0;
    padding-bottom: 1em;
}
</style>


