import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/provider/subcategory/sub_category_provider.dart';
import 'package:fluttermultigrocery/repository/sub_category_repository.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/category.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:fluttermultigrocery/ui/common/expansion_tile.dart' as custom;

class FilterExpantionTileView extends StatefulWidget {
  const FilterExpantionTileView(
      {Key key, this.selectedData, this.category, this.onSubCategoryClick})
      : super(key: key);
  final dynamic selectedData;
  final Category category;
  final Function onSubCategoryClick;
  @override
  State<StatefulWidget> createState() => _FilterExpantionTileView();
}

class _FilterExpantionTileView extends State<FilterExpantionTileView> {
  SubCategoryRepository subCategoryRepository;
  bool isExpanded = false;

  @override
  void initState() {
    super.initState();
  }

  @override
  void dispose() {
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    subCategoryRepository = Provider.of<SubCategoryRepository>(context);

    return ChangeNotifierProvider<SubCategoryProvider>(
        lazy: false,
        create: (BuildContext context) {
          final SubCategoryProvider provider =
              SubCategoryProvider(repo: subCategoryRepository);
          provider.loadAllSubCategoryList(widget.category.id);
          return provider;
        },
        child: Consumer<SubCategoryProvider>(builder:
            (BuildContext context, SubCategoryProvider provider, Widget child) {
          return Container(
              child: custom.ExpansionTile(
            initiallyExpanded: false,
            headerBackgroundColor: PsColors.backgroundColor,
            title: Container(
              child: Row(
                  mainAxisSize: MainAxisSize.max,
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: <Widget>[
                    Expanded(
                      child: Text(
                        widget.category.name,
                        style: Theme.of(context).textTheme.subtitle2,
                      ),
                    ),
                    Container(
                        child: widget.category.id ==
                                widget.selectedData[PsConst.CATEGORY_ID]
                            ? IconButton(
                                icon: Icon(Icons.playlist_add_check,
                                    color: Theme.of(context)
                                        .iconTheme
                                        .copyWith(color: PsColors.mainColor)
                                        .color),
                                onPressed: () {})
                            : Container())
                  ]),
            ),
            children: <Widget>[
              ListView.builder(
                  shrinkWrap: true,
                  physics: const NeverScrollableScrollPhysics(),
                  itemCount: provider.subCategoryList.data.length + 1,
                  itemBuilder: (BuildContext context, int index) {
                    return ListTile(
                      title: Row(
                        mainAxisSize: MainAxisSize.max,
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: <Widget>[
                          Container(
                            child: Padding(
                              padding:
                                  const EdgeInsets.only(left: PsDimens.space16),
                              child: index == 0
                                  ? Text(
                                      Utils.getString(context,
                                              'product_list__category_all') ??
                                          '',
                                      style:
                                          Theme.of(context).textTheme.bodyText2,
                                    )
                                  : Text(
                                      provider
                                          .subCategoryList.data[index - 1].name,
                                      style: Theme.of(context)
                                          .textTheme
                                          .bodyText2),
                            ),
                          ),
                          Container(
                              child: index == 0 &&
                                      widget.category.id ==
                                          widget.selectedData[
                                              PsConst.CATEGORY_ID] &&
                                      widget.selectedData[PsConst.SUB_CATEGORY_ID] ==
                                          ''
                                  ? IconButton(
                                      icon: Icon(Icons.check_circle,
                                          color: Theme.of(context)
                                              .iconTheme
                                              .copyWith(
                                                  color: PsColors.mainColor)
                                              .color),
                                      onPressed: () {})
                                  : index != 0 &&
                                          widget.selectedData[
                                                  PsConst.SUB_CATEGORY_ID] ==
                                              provider.subCategoryList
                                                  .data[index - 1].id
                                      ? IconButton(
                                          icon: Icon(Icons.check_circle,
                                              color: Theme.of(context)
                                                  .iconTheme
                                                  .color),
                                          onPressed: () {})
                                      : Container())
                        ],
                      ),
                      onTap: () {
                        final Map<String, String> dataHolder =
                            <String, String>{};
                        if (index == 0) {
                          dataHolder[PsConst.CATEGORY_ID] = widget.category.id;
                          dataHolder[PsConst.SUB_CATEGORY_ID] = '';
                          dataHolder[PsConst.CATEGORY_NAME] =
                              widget.category.name;
                          widget.onSubCategoryClick(dataHolder);
                        } else {
                          dataHolder[PsConst.CATEGORY_ID] = widget.category.id;
                          dataHolder[PsConst.SUB_CATEGORY_ID] =
                              provider.subCategoryList.data[index - 1].id;
                          dataHolder[PsConst.CATEGORY_NAME] =
                              provider.subCategoryList.data[index - 1].name;
                          widget.onSubCategoryClick(dataHolder);
                        }
                      },
                    );
                  }),
            ],
            onExpansionChanged: (bool expanding) =>
                setState(() => isExpanded = expanding),
          ));
        }));
  }
}
