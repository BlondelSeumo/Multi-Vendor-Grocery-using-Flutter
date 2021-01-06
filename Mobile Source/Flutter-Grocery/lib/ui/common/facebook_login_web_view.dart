import 'package:flutter/material.dart';
import 'package:flutter_webview_plugin/flutter_webview_plugin.dart';

class FacebookLoginWebView extends StatefulWidget {
  const FacebookLoginWebView({this.selectedUrl});
  final String selectedUrl;

  @override
  _FacebookLoginWebViewState createState() => _FacebookLoginWebViewState();
}

class _FacebookLoginWebViewState extends State<FacebookLoginWebView> {
  FlutterWebviewPlugin flutterWebviewPlugin = FlutterWebviewPlugin();

  @override
  void initState() {
    super.initState();

    flutterWebviewPlugin.onUrlChanged.listen((String url) {
      if (url.contains('#access_token')) {
        succeed(url);
      }

      if (url.contains(
          'https://www.facebook.com/connect/login_success.html?error=access_denied&error_code=200&error_description=Permissions+error&error_reason=user_denied')) {
        denied();
      }
    });
  }

  void denied() {
    Navigator.pop(context);
  }

  void succeed(String url) {
    final List<String> params = url.split('access_token=');

    final List<String> endparam = params[1].split('&');

    Navigator.pop(context, endparam[0]);
  }

  @override
  Widget build(BuildContext context) {
    return WebviewScaffold(
        url: widget.selectedUrl,
        appBar: AppBar(
          backgroundColor: const Color.fromRGBO(66, 103, 178, 1),
          title: const Text('Facebook login'),
        ));
  }
}
