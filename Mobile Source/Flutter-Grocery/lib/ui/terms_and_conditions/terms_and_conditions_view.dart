import 'package:flutter/material.dart';
import 'package:flutter_widget_from_html/flutter_widget_from_html.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/provider/about_app/about_app_provider.dart';
import 'package:fluttermultigrocery/repository/about_app_repository.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:provider/provider.dart';

class TermsAndConditionsView extends StatefulWidget {
  const TermsAndConditionsView({Key key, @required this.animationController})
      : super(key: key);
  final AnimationController animationController;
  @override
  _TermsAndConditionsViewState createState() => _TermsAndConditionsViewState();
}

class _TermsAndConditionsViewState extends State<TermsAndConditionsView> {
  AboutAppRepository repo1;
  PsValueHolder psValueHolder;
  AboutAppProvider provider;
  @override
  Widget build(BuildContext context) {
    repo1 = Provider.of<AboutAppRepository>(context);
    psValueHolder = Provider.of<PsValueHolder>(context);
    final Animation<double> animation = Tween<double>(begin: 0.0, end: 1.0)
        .animate(CurvedAnimation(
            parent: widget.animationController,
            curve: const Interval(0.5 * 1, 1.0, curve: Curves.fastOutSlowIn)));
    widget.animationController.forward();
    return ChangeNotifierProvider<AboutAppProvider>(
        lazy: false,
        create: (BuildContext context) {
          provider =
              AboutAppProvider(repo: repo1, psValueHolder: psValueHolder);
          provider.loadAboutAppList();
          return provider;
        },
        child: Consumer<AboutAppProvider>(builder: (BuildContext context,
            AboutAppProvider basketProvider, Widget child) {
          if (provider.aboutAppList.data == null ||
              provider.aboutAppList.data.isEmpty) {
            return Container();
          } else {
            return AnimatedBuilder(
              animation: widget.animationController,
              child: Padding(
                padding: const EdgeInsets.all(PsDimens.space10),
                child: SingleChildScrollView(
                  child: HtmlWidget(
                    provider.aboutAppList.data[0].privacypolicy,
                  ),
                ),
              ),
              builder: (BuildContext context, Widget child) {
                return FadeTransition(
                  opacity: animation,
                  child: Transform(
                    transform: Matrix4.translationValues(
                        0.0, 100 * (1.0 - animation.value), 0.0),
                    child: child,
                  ),
                );
              },
            );
          }
        }));
  }
}
