import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class PsWidgetWithAppBarNoAppBarTitle<T extends ChangeNotifier>
    extends StatefulWidget {
  const PsWidgetWithAppBarNoAppBarTitle({
    Key key,
    @required this.builder,
    @required this.initProvider,
    this.child,
    this.onProviderReady,
  }) : super(key: key);

  final Widget Function(BuildContext context, T provider, Widget child) builder;
  final Function initProvider;
  final Widget child;
  final Function(T) onProviderReady;

  @override
  _PsWidgetWithAppBarState<T> createState() => _PsWidgetWithAppBarState<T>();
}

class _PsWidgetWithAppBarState<T extends ChangeNotifier>
    extends State<PsWidgetWithAppBarNoAppBarTitle<T>> {
  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        //     appBar: AppBar(
        //       brightness: Utils.getBrightnessForAppBar(context),
        //       iconTheme: IconThemeData(color: Theme.of(context).iconTheme.color),
        //       title: Text(widget.appBarTitle,
        //           style: Theme.of(context)
        //               .textTheme
        //               .headline6
        //               .copyWith(fontWeight: FontWeight.bold)),
        //       flexibleSpace: Container(
        //         height: 200,
        //   ),
        // ),
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
