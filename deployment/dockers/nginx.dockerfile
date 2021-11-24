FROM nginx:latest

COPY ./deployment/configs/nginx_monolith_mvp.conf /etc/nginx/conf.d/