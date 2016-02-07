#############################################
#       Teddy Online Judge - Runner
#############################################
FROM ubuntu:15.10
MAINTAINER Alan Gonzalez<alanboy@alanboy.net>

ENV DEBIAN_FRONTEND=noninteractive

# Get some security updates
RUN dpkg --configure -a --force-all
RUN apt-get clean
RUN apt-get update
RUN apt-get -y upgrade

# Tools and dependencies
RUN apt-get -y install supervisor \
  software-properties-common \
  git \
  curl \
  wget \
  vim \
  clang \
  libicu-dev \
  libpython2.7 \
  openjdk-8-jdk \
  gcc \
  g++ \
  ruby \
  nodejs \
  mono-gmcs \
  elixir \
  golang

# Compilers and interpreters that require extra steps
## Updated PHP
RUN add-apt-repository -y ppa:ondrej/php
RUN apt-get update && apt-get -y --force-yes install php

## Crystal needs curl, so it gets its own APT line
RUN curl http://dist.crystal-lang.org/apt/setup.sh | bash
RUN apt-get -y install crystal

## Rust
RUN wget https://static.rust-lang.org/rustup.sh
RUN chmod +x rustup.sh
RUN ./rustup.sh -y --disable-sudo

## Apple Swift
RUN wget https://swift.org/builds/ubuntu1510/swift-2.2-SNAPSHOT-2016-01-11-a/swift-2.2-SNAPSHOT-2016-01-11-a-ubuntu15.10.tar.gz
RUN tar -xvzf swift-2.2-SNAPSHOT-2016-01-11-a-ubuntu15.10.tar.gz
RUN mv swift-2.2-SNAPSHOT-2016-01-11-a-ubuntu15.10 apple-swift
RUN ln -s /apple-swift/usr/bin/swift /usr/local/bin/swift
RUN ln -s /apple-swift/usr/bin/swift /usr/local/bin/swiftc
RUN ln -s /apple-swift/usr/bin/swift /usr/local/bin/swift-autolink-extract
RUN ln -s /apple-swift/usr/bin/swift-build /usr/local/bin/swift-build
RUN ln -s /apple-swift/usr/bin/swift-build-tool /usr/local/bin/swift-build-tool
RUN ln -s /apple-swift/usr/bin/swift-compress /usr/local/bin/swift-compress
RUN ln -s /apple-swift/usr/bin/swift-demangle /usr/local/bin/swift-demangle
RUN ln -s /apple-swift/usr/bin/repl-swift /usr/local/bin/repl-swift
RUN ln -s /apple-swift/usr/bin/lldb-3.8.0 /usr/local/bin/lldb-3.8.0
RUN ln -s /apple-swift/usr/bin/lldb-3.8.0 /usr/local/bin/lldb
RUN ln -s /apple-swift/usr/bin/lldb-mi-3.8.0 /usr/local/bin/lldb-mi-3.8.0
RUN ln -s /apple-swift/usr/bin/lldb-mi-3.8.0 /usr/local/bin/lldb-mi
RUN ln -s /apple-swift/usr/bin/lldb-server-3.8.0 /usr/local/bin/lldb-server-3.8.0
RUN ln -s /apple-swift/usr/bin/lldb-server-3.8.0 /usr/local/bin/lldb-server
RUN ln -s /apple-swift/usr/bin/lldb-argdumper /usr/local/bin/lldb-argdumper

# Clean all the stuff laying around
RUN rm rustup.sh
RUN rm swift-2.2-SNAPSHOT-2016-01-11-a-ubuntu15.10.tar.gz
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Setup for Teddy
RUN mkdir --parents /opt/teddy/runner
RUN mkdir --parents /var/tmp/teddy/work_zone

RUN echo "\$TEDDY_DB_USER = \"root\";" >> /opt/teddy/runner/config.php
RUN echo "\$TEDDY_DB_SERVER = \"web\";" >> /opt/teddy/runner/config.php
RUN echo "\$TEDDY_DB_NAME = \"teddy\";" >> /opt/teddy/runner/config.php
RUN echo "\$TEDDY_DB_PASSWORD= \"\";" >> /opt/teddy/runner/config.php

ADD conf/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord"]
