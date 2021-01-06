import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class PsWidget<T extends ChangeNotifier> extends StatefulWidget {
  const PsWidget(
      {Key key,
      @required this.builder,
      @required this.initProvider,
      this.child,
      this.onProviderReady,
      this.actions = const <Widget>[]})
      : super(key: key);

  final Widget Function(BuildContext context, T provider, Widget child) builder;
  final Function initProvider;
  final Widget child;
  final Function(T) onProviderReady;
  final List<Widget> actions;

  @override
  _PsWidgetState<T> createState() => _PsWidgetState<T>();
}

class _PsWidgetState<T extends ChangeNotifier> extends State<PsWidget<T>> {
  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
  return Scaffold(
            body: ChangeNotifierProvider<T>(
              lazy: false,
          create: (BuildContext context) {
            final T providerObj = widget.initProvider();
            if (widget.onProviderReady != null) {
              widget.onProviderReady(providerObj);
            }

            return providerObj;
          },
          child: Consumer<T>(
            builder: widget.builder,
            child: widget.child,
          ),
        ));
  }
}
