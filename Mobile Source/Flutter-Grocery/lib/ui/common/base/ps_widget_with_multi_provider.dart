import 'package:flutter/material.dart';

class PsWidgetWithMultiProvider extends StatefulWidget {
  const PsWidgetWithMultiProvider({
    Key key,
    this.child,
  }) : super(key: key);

  final Widget child;

  @override
  _PsWidgetWithMultiProviderState createState() => _PsWidgetWithMultiProviderState();
}

class _PsWidgetWithMultiProviderState extends State<PsWidgetWithMultiProvider> {
  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(body: widget.child
        );
  }
}
