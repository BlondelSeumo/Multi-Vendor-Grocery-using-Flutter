import 'package:flutter/material.dart';
import 'package:flutter_widget_from_html/flutter_widget_from_html.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/provider/about_app/about_app_provider.dart';
import 'package:fluttermultigrocery/repository/about_app_repository.dart';
import 'package:fluttermultigrocery/ui/common/base/ps_widget_with_appbar.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:provider/provider.dart';

class SettingPrivacyPolicyView extends StatefulWidget {
  const SettingPrivacyPolicyView(
      {@required this.title, @required this.description});
  final String title;
  final String description;
  @override
  _SettingPrivacyPolicyViewState createState() {
    return _SettingPrivacyPolicyViewState();
  }
}

class _SettingPrivacyPolicyViewState extends State<SettingPrivacyPolicyView>
    with SingleTickerProviderStateMixin {
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
    super.initState();

    animationController = AnimationController(
      vsync: this,
      duration: const Duration(seconds: 3),
    )..addListener(() => setState(() {}));

    animation = Tween<double>(
      begin: 0.0,
      end: 10.0,
    ).animate(animationController);
  }

  AboutAppRepository repo1;
  PsValueHolder valueHolder;
  @override
  Widget build(BuildContext context) {
    repo1 = Provider.of<AboutAppRepository>(context);
    valueHolder = Provider.of<PsValueHolder>(context);
    return PsWidgetWithAppBar<AboutAppProvider>(
        appBarTitle: widget.title,
        initProvider: () {
          return AboutAppProvider(
            repo: repo1,
            psValueHolder: valueHolder,
          );
        },
        onProviderReady: (AboutAppProvider provider) {
          provider.loadAboutAppList();
          return provider;
        },
        builder:
            (BuildContext context, AboutAppProvider provider, Widget child) {
          if (provider.aboutAppList != null &&
              provider.aboutAppList.data != null &&
              provider.aboutAppList.data.isNotEmpty) {
            return Padding(
              padding: const EdgeInsets.all(PsDimens.space10),
              child: SingleChildScrollView(
                child: widget.description == null || widget.description == ''
                    ? HtmlWidget(provider.aboutAppList.data[0].privacypolicy)
                    : Text(widget.description),
              ),
            );
          } else {
            return Container();
          }
        });
  }
}
