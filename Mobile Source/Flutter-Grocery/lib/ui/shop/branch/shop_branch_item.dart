import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/viewobject/shop_branch.dart';
import 'package:url_launcher/url_launcher.dart';

class ShopBranchItem extends StatelessWidget {
  const ShopBranchItem({
    Key key,
    @required this.shopbranch,
    this.onTap,
  }) : super(key: key);

  final ShopBranch shopbranch;
  final Function onTap;

  @override
  Widget build(BuildContext context) {
    const Widget _spacingWidget = SizedBox(
      height: PsDimens.space14,
    );
    return Container(
      color: PsColors.backgroundColor,
      margin: const EdgeInsets.only(top: PsDimens.space8),
      padding: const EdgeInsets.all(PsDimens.space16),
      child: Column(
        children: <Widget>[
          const SizedBox(
            height: PsDimens.space8,
          ),
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: <Widget>[
              const Align(
                alignment: Alignment.centerLeft,
              ),
              GestureDetector(
                child: Text(
                  shopbranch.name,
                  style: Theme.of(context).textTheme.bodyText2.copyWith(),
                ),
              ),
              _spacingWidget,
              GestureDetector(
                child: Text(
                  shopbranch.phone,
                  style: Theme.of(context).textTheme.bodyText2.copyWith(),
                ),
                onTap: () async {
                  if (await canLaunch('tel://${shopbranch.phone}')) {
                    await launch('tel://${shopbranch.phone}');
                  } else {
                    throw 'Could not Call Phone Number 3';
                  }
                },
              ),
              _spacingWidget,
              GestureDetector(
                child: Text(
                  shopbranch.address,
                  style: Theme.of(context).textTheme.bodyText2.copyWith(),
                ),
              ),
              _spacingWidget,
              GestureDetector(
                child: Text(
                  shopbranch.description,
                  style: Theme.of(context).textTheme.bodyText2.copyWith(),
                ),
              ),
              _spacingWidget,
            ],
          )
        ],
      ),
    );
  }
}
