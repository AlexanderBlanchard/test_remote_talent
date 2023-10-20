# Usar una imagen base de Node
FROM node:lts-alpine

# Directorio de trabajo
WORKDIR /app

# Copiar package.json y package-lock.json para instalar dependencias
COPY package*.json ./

# Instalar dependencias
RUN npm install

# Copiar el resto de los archivos de la aplicación
COPY . .

# Exponer el puerto 8080
EXPOSE 8080

# Comando para servir la aplicación
CMD ["npm", "run", "serve"]
