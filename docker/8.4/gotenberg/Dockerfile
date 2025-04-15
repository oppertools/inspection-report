FROM gotenberg/gotenberg:8

USER root

COPY fonts/* /usr/local/share/fonts/

RUN fc-cache -f -v

USER gotenberg
