#!/bin/sh
openssl s_client -connect gateway.push.apple.com:2195 -cert PushChatCert.pem -key PushChatKey.pem
#openssl s_client -connect gateway.sandbox.push.apple.com:2195 -cert PushChatCert.pem -key PushChatKey.pem