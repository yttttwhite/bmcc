/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements. See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership. The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied. See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

#ifndef _THRIFT_TEVHTTP_CLIENT_CHANNEL_H_
#define _THRIFT_TEVHTTP_CLIENT_CHANNEL_H_ 1

#include <string>
#include <boost/shared_ptr.hpp>
#include <thrift/async/TAsyncChannel.h>

struct event_base;
struct evhttps_connection;
struct evhttps_request;

namespace apache { namespace thrift { namespace transport {
class TMemoryBuffer;
}}}

namespace apache { namespace thrift { namespace async {

class TEvhttpsClientChannel : public TAsyncChannel {
 public:
  using TAsyncChannel::VoidCallback;

  TEvhttpsClientChannel(
      const std::string& host,
      const std::string& path,
      const char* address,
      int port,
      struct event_base* eb);
  ~TEvhttpsClientChannel();

  virtual void sendAndRecvMessage(const VoidCallback& cob,
                                  apache::thrift::transport::TMemoryBuffer* sendBuf,
                                  apache::thrift::transport::TMemoryBuffer* recvBuf);

  virtual void sendMessage(const VoidCallback& cob, apache::thrift::transport::TMemoryBuffer* message);
  virtual void recvMessage(const VoidCallback& cob, apache::thrift::transport::TMemoryBuffer* message);

  void finish(struct evhttps_request* req);

  //XXX
  virtual bool good() const { return true; }
  virtual bool error() const { return false; }
  virtual bool timedOut() const { return false; }

 private:
  static void response(struct evhttps_request* req, void* arg);

  std::string host_;
  std::string path_;
  VoidCallback cob_;
  apache::thrift::transport::TMemoryBuffer* recvBuf_;
  struct evhttps_connection* conn_;

};

}}} // apache::thrift::async

#endif // #ifndef _THRIFT_TEVHTTP_CLIENT_CHANNEL_H_
