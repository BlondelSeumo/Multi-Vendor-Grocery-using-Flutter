import 'package:flutter_icons/flutter_icons.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/ui/common/ps_expansion_tile.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/viewobject/shop_info.dart';
import 'package:url_launcher/url_launcher.dart';

class ContactUsTileView extends StatelessWidget {
  const ContactUsTileView({
    Key key,
    @required this.shopInfo,
  }) : super(key: key);

  final ShopInfo shopInfo;
  @override
  Widget build(BuildContext context) {
    final Widget _expansionTileTitleWidget = Text(
        Utils.getString(context, 'shop_info__contact'),
        style: Theme.of(context).textTheme.subtitle1);
    if (shopInfo != null && shopInfo.description != null) {
      return Container(
        margin: const EdgeInsets.only(
            left: PsDimens.space12,
            right: PsDimens.space12,
            bottom: PsDimens.space12),
        decoration: BoxDecoration(
          color: PsColors.backgroundColor,
          borderRadius:
              const BorderRadius.all(Radius.circular(PsDimens.space8)),
        ),
        child: PsExpansionTile(
          initiallyExpanded: true,
          title: _expansionTileTitleWidget,
          children: <Widget>[
            Padding(
              padding: const EdgeInsets.only(
                  bottom: PsDimens.space16,
                  left: PsDimens.space16,
                  right: PsDimens.space16),
              child: Column(
                children: <Widget>[
                  _PhoneAndContactWidget(
                    phone: shopInfo,
                  ),
                  _LinkAndTitle(
                      icon: FontAwesome.wordpress,
                      title: Utils.getString(
                          context, 'shop_info__visit_our_website'),
                      link: shopInfo.aboutWebsite),
                  _LinkAndTitle(
                      icon: FontAwesome.facebook,
                      title: Utils.getString(context, 'shop_info__facebook'),
                      link: shopInfo.facebook),
                  _LinkAndTitle(
                      icon: FontAwesome.google_plus_circle,
                      title: Utils.getString(context, 'shop_info__google_plus'),
                      link: shopInfo.googlePlus),
                  _LinkAndTitle(
                      icon: FontAwesome.twitter_square,
                      title: Utils.getString(context, 'shop_info__twitter'),
                      link: shopInfo.twitter),
                  _LinkAndTitle(
                      icon: FontAwesome.instagram,
                      title: Utils.getString(context, 'shop_info__instagram'),
                      link: shopInfo.instagram),
                  _LinkAndTitle(
                      icon: FontAwesome.youtube,
                      title: Utils.getString(context, 'shop_info__youtube'),
                      link: shopInfo.youtube),
                  _LinkAndTitle(
                      icon: FontAwesome.pinterest,
                      title: Utils.getString(context, 'shop_info__pinterest'),
                      link: shopInfo.pinterest),
                ],
              ),
            )
          ],
        ),
      );
    } else {
      return const Card();
    }
  }
}

class _PhoneAndContactWidget extends StatelessWidget {
  const _PhoneAndContactWidget({
    Key key,
    @required this.phone,
  }) : super(key: key);

  final ShopInfo phone;
  @override
  Widget build(BuildContext context) {
    const Widget _spacingWidget = SizedBox(
      height: PsDimens.space16,
    );
    return Container(
        color: PsColors.backgroundColor,
        margin: const EdgeInsets.only(top: PsDimens.space16),
        padding: const EdgeInsets.only(
            left: PsDimens.space16, right: PsDimens.space16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: <Widget>[
            _spacingWidget,
            Row(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: <Widget>[
                Container(
                    width: PsDimens.space20,
                    height: PsDimens.space20,
                    child: const Icon(
                      Icons.phone_in_talk,
                    )),
                const SizedBox(
                  width: PsDimens.space12,
                ),
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: <Widget>[
                    Text(
                      Utils.getString(context, 'shop_info__phone'),
                      style: Theme.of(context).textTheme.subtitle1,
                    ),
                    _spacingWidget,
                    InkWell(
                      child: Text(
                        phone.aboutPhone1 == '' ? '-' : phone.aboutPhone1,
                        style: Theme.of(context).textTheme.bodyText1.copyWith(),
                      ),
                      onTap: () async {
                        if (await canLaunch('tel://${phone.aboutPhone1}')) {
                          await launch('tel://${phone.aboutPhone1}');
                        } else {
                          throw 'Could not Call Phone Number 1';
                        }
                      },
                    ),
                    _spacingWidget,
                    InkWell(
                      child: Text(
                        phone.aboutPhone2 == '' ? '-' : phone.aboutPhone2,
                        style: Theme.of(context).textTheme.bodyText1.copyWith(),
                      ),
                      onTap: () async {
                        if (await canLaunch('tel://${phone.aboutPhone2}')) {
                          await launch('tel://${phone.aboutPhone2}');
                        } else {
                          throw 'Could not Call Phone Number 2';
                        }
                      },
                    ),
                    _spacingWidget,
                    InkWell(
                      child: Text(
                        phone.aboutPhone3 == '' ? '-' : phone.aboutPhone3,
                        style: Theme.of(context).textTheme.bodyText1.copyWith(),
                      ),
                      onTap: () async {
                        if (await canLaunch('tel://${phone.aboutPhone3}')) {
                          await launch('tel://${phone.aboutPhone3}');
                        } else {
                          throw 'Could not Call Phone Number 3';
                        }
                      },
                    ),
                  ],
                ),
              ],
            ),
            _spacingWidget,
          ],
        ));
  }
}

class _LinkAndTitle extends StatelessWidget {
  const _LinkAndTitle({
    Key key,
    @required this.icon,
    @required this.title,
    @required this.link,
  }) : super(key: key);

  final IconData icon;
  final String title;
  final String link;

  @override
  Widget build(BuildContext context) {
    return Container(
        color: PsColors.backgroundColor,
        margin: const EdgeInsets.only(top: PsDimens.space8),
        padding: const EdgeInsets.all(PsDimens.space16),
        child: Column(
          children: <Widget>[
            Align(
              alignment: Alignment.centerLeft,
              child: Row(
                children: <Widget>[
                  Container(
                      width: PsDimens.space20,
                      height: PsDimens.space20,
                      child: Icon(
                        icon,
                      )),
                  const SizedBox(
                    width: PsDimens.space12,
                  ),
                  Text(
                    title,
                    style: Theme.of(context).textTheme.bodyText2,
                  ),
                ],
              ),
            ),
            const SizedBox(
              height: PsDimens.space8,
            ),
            Align(
              alignment: Alignment.centerLeft,
              child: Row(
                children: <Widget>[
                  const SizedBox(
                    width: PsDimens.space32,
                  ),
                  InkWell(
                    child: Text(
                        link == ''
                            ? Utils.getString(context, 'shop_info__dash')
                            : link,
                        style: Theme.of(context).textTheme.bodyText1),
                    onTap: () async {
                      if (await canLaunch(link)) {
                        await launch(link);
                      } else {
                        throw 'Could not launch $link';
                      }
                    },
                  ),
                ],
              ),
            )
          ],
        ));
  }
}
