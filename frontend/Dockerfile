FROM node:12 as builder

WORKDIR /opt/app

COPY package*.json ./

RUN npm ci

COPY . .

RUN npm run build -- --configuration=docker


FROM nginx:1.17-alpine

COPY docker/nginx.conf /etc/nginx/nginx.conf

RUN rm -rf /usr/share/nginx/html/*

COPY --from=builder /opt/app/dist /usr/share/nginx/html
COPY docker/runtime.js /usr/share/nginx/html/assets/runtime.js.template

COPY docker/startup.sh /root/startup.sh
RUN chmod +x /root/startup.sh

WORKDIR /usr/share/nginx/html

CMD /root/startup.sh
