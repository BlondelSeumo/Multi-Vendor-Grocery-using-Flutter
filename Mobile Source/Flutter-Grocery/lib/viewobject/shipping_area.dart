import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:quiver/core.dart';

class ShippingArea extends PsObject<ShippingArea> {
  ShippingArea({
    this.id,
    this.areaName,
    this.price,
    this.status,
    this.addedDate,
    this.addedUserId,
    this.updatedDate,
    this.updatedUserId,
    this.addedDateStr,
    this.currencySymbol,
    this.currencyShortForm,
  });
  String id;
  String areaName;
  String price;
  String status;
  String addedDate;
  String addedUserId;
  String updatedDate;
  String updatedUserId;
  String addedDateStr;
  String currencySymbol;
  String currencyShortForm;
  @override
  bool operator ==(dynamic other) => other is ShippingArea && id == other.id;

  @override
  int get hashCode {
    return hash2(id.hashCode, id.hashCode);
  }

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  ShippingArea fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return ShippingArea(
        id: dynamicData['id'],
        areaName: dynamicData['area_name'],
        price: dynamicData['price'],
        status: dynamicData['status'],
        addedDate: dynamicData['added_date'],
        addedUserId: dynamicData['added_user_id'],
        updatedDate: dynamicData['updated_date'],
        updatedUserId: dynamicData['updated_user_id'],
        addedDateStr: dynamicData['added_date_str'],
        currencySymbol: dynamicData['currency_symbol'],
        currencyShortForm: dynamicData['currency_short_form'],
      );
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(ShippingArea object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['area_name'] = object.areaName;
      data['price'] = object.price;
      data['status'] = object.status;
      data['added_date'] = object.addedDate;
      data['added_user_id'] = object.addedUserId;
      data['updated_date'] = object.updatedUserId;
      data['added_date_str'] = object.addedDateStr;
      data['currency_symbol'] = object.currencySymbol;
      data['currency_short_form'] = object.currencyShortForm;

      return data;
    } else {
      return null;
    }
  }

  @override
  List<ShippingArea> fromMapList(List<dynamic> dynamicDataList) {
    final List<ShippingArea> shippingAreaList = <ShippingArea>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          shippingAreaList.add(fromMap(dynamicData));
        }
      }
    }
    return shippingAreaList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<ShippingArea> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (ShippingArea data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }
    return mapList;
  }
}
