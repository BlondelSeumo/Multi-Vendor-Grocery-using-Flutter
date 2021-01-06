import 'package:fluttermultigrocery/config/ps_config.dart';
import 'package:fluttermultigrocery/ui/transaction/list/transaction_list_view.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:flutter/material.dart';

class TransactionListContainerView extends StatefulWidget {
  @override
  _TransactionListContainerViewState createState() =>
      _TransactionListContainerViewState();
}

class _TransactionListContainerViewState
    extends State<TransactionListContainerView>
    with SingleTickerProviderStateMixin {
  AnimationController animationController;
  @override
  void initState() {
    animationController =
        AnimationController(duration: PsConfig.animation_duration, vsync: this);
    super.initState();
  }

  @override
  void dispose() {
    animationController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final GlobalKey<ScaffoldState> scaffoldKey = GlobalKey<ScaffoldState>();
    Future<bool> _requestPop() {
      animationController.reverse().then<dynamic>(
        (void data) {
          if (!mounted) {
            return Future<bool>.value(false);
          }
          Navigator.pop(context, true);
          return Future<bool>.value(true);
        },
      );
      return Future<bool>.value(false);
    }

    print(
        '............................Build UI Again ............................');
    return WillPopScope(
      onWillPop: _requestPop,
      child: Scaffold(
        key: scaffoldKey,
        appBar: AppBar(
          brightness: Utils.getBrightnessForAppBar(context),
          iconTheme: Theme.of(context).iconTheme.copyWith(),
          title: Text(Utils.getString(context, 'transaction_list__title'),
              textAlign: TextAlign.center,
              style: Theme.of(context).textTheme.headline6.copyWith(
                    fontWeight: FontWeight.bold,
                  )),
          elevation: 0,
        ),
        body: TransactionListView(
          scaffoldKey: scaffoldKey,
          animationController: animationController,
        ),
      ),
    );
  }
}
