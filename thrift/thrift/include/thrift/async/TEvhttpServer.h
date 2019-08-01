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

#ifndef _THRIFT_TEVHTTP_SERVER_H_
#define _THRIFT_TEVHTTP_SERVER_H_ 1

#include <boost/shared_ptr.hpp>

struct event_base;
struct evhttps;
struct evhttps_request;

namespace apache { namespace thrift { namespace async {

class TAsyncBufferProcessor;

class TEvhttpsServer {
 public:
  /**
   * Create a TEvhttpsServer for use with an external evhttps instance.
   * Must be manually installed with evhttps_set_cb, using
   * TEvhttpsServer::request as the callback and the
   * address of the server as the extra arg.
   * Do not call "serve" on this server.
   */
  TEvhttpsServer(boost::shared_ptr<TAsyncBufferProcessor> processor);

  /**
   * Create a TEvhttpsServer with an embedded event_base and evhttps,
   * listening on port and responding on the endpoint "/".
   * Call "serve" on this server to serve forever.
   */
  TEvhttpsServer(boost::shared_ptr<TAsyncBufferProcessor> processor, int port);

  ~TEvhttpsServer();

  static void request(struct evhttps_request* req, void* self);
  int serve();

  struct event_base* getEventBase();

 private:
  struct RequestContext;

  void process(struct evhttps_request* req);
  void complete(RequestContext* ctx, bool success);

  boost::shared_ptr<TAsyncBufferProcessor> processor_;
  struct event_base* eb_;
  struct evhttps* eh_;
};

}}} // apache::thrift::async

#endif // #ifndef _THRIFT_TEVHTTP_SERVER_H_
