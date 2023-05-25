# Use Ubuntu as the base image
FROM ubuntu:latest

# Install Monit
RUN apt-get update && \ 
    apt-get install -y monit

# Add configuration file
COPY monitrc /etc/monit/

# Set the permissions for the config file
RUN chmod 0700 /etc/monit/monitrc && \
    ln -s /etc/monit/conf-available/apache2 /etc/monit/conf-enabled/ && \
    monit reload

# Expose the Monit httpd port
EXPOSE 2812

# Run Monit in the foreground
CMD ["monit", "-I"]
