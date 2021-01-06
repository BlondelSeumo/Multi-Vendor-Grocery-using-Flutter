import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/constant/route_paths.dart';
import 'package:fluttermultigrocery/ui/common/ps_expansion_tile.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/privacy_policy_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/product.dart';

class TermsAndPolicyTileView extends StatefulWidget {
  const TermsAndPolicyTileView(this.product);
  final Product product;

  @override
  _TermsAndPolicyTileViewState createState() => _TermsAndPolicyTileViewState();
}

class _TermsAndPolicyTileViewState extends State<TermsAndPolicyTileView> {
  @override
  Widget build(BuildContext context) {
    final Widget _expansionTileTitleWidget = Text(
        Utils.getString(context, 'terms_and_policy_tile__terms_and_policy'),
        style: Theme.of(context).textTheme.subtitle1);

    return Container(
      margin: const EdgeInsets.only(
          left: PsDimens.space12,
          right: PsDimens.space12,
          bottom: PsDimens.space12),
      decoration: BoxDecoration(
        color: PsColors.backgroundColor,
        borderRadius: const BorderRadius.all(Radius.circular(PsDimens.space8)),
      ),
      child: PsExpansionTile(
        initiallyExpanded: true,
        title: _expansionTileTitleWidget,
        children: <Widget>[
          Column(
            children: <Widget>[
              InkWell(
                onTap: () {
                  Navigator.pushNamed(context, RoutePaths.privacyPolicy,
                      arguments: PrivacyPolicyIntentHolder(
                          title: Utils.getString(
                              context, 'terms_and_condition__toolbar_name'),
                          description: widget.product.shop.terms));
                },
                child: Padding(
                  padding: const EdgeInsets.only(
                      top: PsDimens.space16,
                      left: PsDimens.space16,
                      right: PsDimens.space16,
                      bottom: PsDimens.space16),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: <Widget>[
                      Text(
                        Utils.getString(context,
                            'terms_and_policy_tile__terms_and_condition'),
                        style: Theme.of(context)
                            .textTheme
                            .bodyText2
                            .copyWith(color: PsColors.mainColor),
                      ),
                      GestureDetector(
                          onTap: () {
                            Navigator.pushNamed(
                                context, RoutePaths.privacyPolicy,
                                arguments: PrivacyPolicyIntentHolder(
                                    title: Utils.getString(context,
                                        'terms_and_condition__toolbar_name'),
                                    description: widget.product.shop.terms));
                          },
                          child: const Icon(
                            Icons.arrow_forward_ios,
                            size: PsDimens.space16,
                          )),
                    ],
                  ),
                ),
              ),
              InkWell(
                onTap: () {
                  Navigator.pushNamed(context, RoutePaths.privacyPolicy,
                      arguments: PrivacyPolicyIntentHolder(
                          title: Utils.getString(
                              context, 'refund_policy__toolbar_name'),
                          description: widget.product.shop.refundPolicy));
                },
                child: Padding(
                  padding: const EdgeInsets.only(
                      top: PsDimens.space16,
                      left: PsDimens.space16,
                      right: PsDimens.space16,
                      bottom: PsDimens.space16),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: <Widget>[
                      Text(
                        Utils.getString(
                            context, 'terms_and_policy_tile__refund_policy'),
                        style: Theme.of(context)
                            .textTheme
                            .bodyText2
                            .copyWith(color: PsColors.mainColor),
                      ),
                      GestureDetector(
                          onTap: () {
                            Navigator.pushNamed(
                                context, RoutePaths.privacyPolicy,
                                arguments: PrivacyPolicyIntentHolder(
                                    title: Utils.getString(
                                        context, 'refund_policy__toolbar_name'),
                                    description:
                                        widget.product.shop.refundPolicy));
                          },
                          child: const Icon(
                            Icons.arrow_forward_ios,
                            size: PsDimens.space16,
                          )),
                    ],
                  ),
                ),
              )
            ],
          ),
        ],
      ),
    );
  }
}
