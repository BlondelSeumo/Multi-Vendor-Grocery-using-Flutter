import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/ui/common/ps_dropdown_base_widget.dart';
import 'package:fluttermultigrocery/viewobject/customized_header.dart';

class AttributesItemView extends StatefulWidget {
  const AttributesItemView({
    Key key,
    @required this.customizedHeader,
    this.attributeName,
    this.onTap,
  }) : super(key: key);

  final CustomizedHeader customizedHeader;
  final Function onTap;
  final String attributeName;

  @override
  _AttributesItemViewState createState() => _AttributesItemViewState();
}

class _AttributesItemViewState extends State<AttributesItemView> {
  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: widget.onTap,
      child: Container(
        margin: const EdgeInsets.symmetric(
            horizontal: PsDimens.space2, vertical: PsDimens.space2),
        child: PsDropdownBaseWidget(
          title: widget.customizedHeader.name,
          selectedText: widget.attributeName ?? '',
          onTap: () {
            widget.onTap();
          },
        ),
      ),
    );
  }
}
