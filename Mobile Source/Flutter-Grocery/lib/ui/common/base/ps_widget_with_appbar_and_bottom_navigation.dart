import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class PsWidgetWithAppBarAndBottomNavigation<T extends ChangeNotifier>
    extends StatefulWidget {
  const PsWidgetWithAppBarAndBottomNavigation(
      {Key key,
      @required this.builder,
      @required this.initProvider,
      @required this.bottonNavigationView,
      this.child,
      this.onProviderReady,
      @required this.appBarTitle})
      : super(key: key);

  final Widget Function(BuildContext context, T provider, Widget child) builder;
  final Function initProvider;
  final Widget child;
  final Function(T) onProviderReady;
  final String appBarTitle;
  final Widget bottonNavigationView;

  @override
  _PsWidgetWithAppBarAndBottomNavigation<T> createState() =>
      _PsWidgetWithAppBarAndBottomNavigation<T>();
}

class _PsWidgetWithAppBarAndBottomNavigation<T extends ChangeNotifier>
    extends State<PsWidgetWithAppBarAndBottomNavigation<T>> {
  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          brightness: Utils.getBrightnessForAppBar(context),
          iconTheme: IconThemeData(color: Theme.of(context).iconTheme.color),
          title: Text(widget.appBarTitle,
              style: Theme.of(context)
                  .textTheme
                  .headline6
                  .copyWith(fontWeight: FontWeight.bold)),
          flexibleSpace: Container(
            height: 200,
          ),
        ),
        bottomNavigationBar: widget.bottonNavigationView,
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
