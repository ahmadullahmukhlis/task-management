FROM node:latest as build-stage

WORKDIR /app

COPY package*.json ./

# Force dependencies to install smoothly despite peer warnings
RUN npm install --force

COPY . .

# 🟢 REMOVED the broken .env move command. 
# Vite will automatically read variables injected by Render at build time.
RUN npm run build

FROM nginx:alpine

COPY --from=build-stage /app/dist /usr/share/nginx/html
RUN rm -f /usr/share/nginx/html/index.html
RUN mv /usr/share/nginx/html/spa/* /usr/share/nginx/html/

RUN rm -f /etc/nginx/conf.d/default.conf
COPY default.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
