import 'package:fluttermultigrocery/config/ps_config.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/provider/language/language_provider.dart';
import 'package:fluttermultigrocery/ui/common/base/ps_widget_with_appbar.dart';
import 'package:fluttermultigrocery/ui/common/dialog/confirm_dialog_view.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:flutter/material.dart';
import 'package:flutter/scheduler.dart';
import 'package:provider/provider.dart';
import 'package:fluttermultigrocery/repository/language_repository.dart';

import '../item/language_list_item.dart';

class LanguageListView extends StatefulWidget {
  @override
  _LanguageListViewState createState() => _LanguageListViewState();
}

class _LanguageListViewState extends State<LanguageListView>
    with SingleTickerProviderStateMixin {
  LanguageRepository repo1;

  AnimationController animationController;
  Animation<double> animation;

  @override
  void dispose() {
    animationController.dispose();
    animation = null;
    super.dispose();
  }

  @override
  void initState() {
    animationController =
        AnimationController(duration: PsConfig.animation_duration, vsync: this);

    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    repo1 = Provider.of<LanguageRepository>(context);
    timeDilation = 1.0;
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

    return WillPopScope(
      onWillPop: _requestPop,
      child: PsWidgetWithAppBar<LanguageProvider>(
        appBarTitle:
            Utils.getString(context, 'language_selection__title') ?? '',
        initProvider: () {
          return LanguageProvider(repo: repo1);
        },
        onProviderReady: (LanguageProvider provider) {
          provider.getLanguageList();
        },
        builder:
            (BuildContext context, LanguageProvider provider, Widget child) {
          return Padding(
            padding: const EdgeInsets.only(
                top: PsDimens.space8, bottom: PsDimens.space8),
            child: ListView.builder(
              shrinkWrap: true,
              itemCount: provider.languageList.length,
              itemBuilder: (BuildContext context, int index) {
                final int count = provider.languageList.length;
                return LanguageListItem(
                    language: provider.languageList[index],
                    animationController: animationController,
                    animation: Tween<double>(begin: 0.0, end: 1.0)
                        .animate(CurvedAnimation(
                      parent: animationController,
                      curve: Interval((1 / count) * index, 1.0,
                          curve: Curves.fastOutSlowIn),
                    )),
                    onTap: () {
                      showDialog<dynamic>(
                          context: context,
                          builder: (BuildContext context) {
                            return ConfirmDialogView(
                                description: Utils.getString(context,
                                    'home__language_dialog_description'),
                                leftButtonText: Utils.getString(
                                    context, 'app_info__cancel_button_name'),
                                rightButtonText:
                                    Utils.getString(context, 'dialog__ok'),
                                onAgreeTap: () {
                                  Navigator.of(context).pop();
                                  Navigator.pop(
                                      context, provider.languageList[index]);
                                });
                          });
                    });
              },
            ),
          );
        },
      ),
    );
  }
}
