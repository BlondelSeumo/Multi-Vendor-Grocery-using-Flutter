import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';

class ShopBranch extends PsObject<ShopBranch> {
  ShopBranch({
    this.id,
    this.shopId,
    this.name,
    this.description,
    this.address,
    this.phone,
    this.status,
    this.addedDate,
    this.addedUserId,
    this.updatedDate,
    this.updatedUserId,
    this.updatedFlag,
  });
  String id;
  String shopId;
  String name;
  String description;
  String address;
  String phone;
  String status;
  String addedDate;
  String addedUserId;
  String updatedDate;
  String updatedUserId;
  String updatedFlag;

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  ShopBranch fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return ShopBranch(
        id: dynamicData['id'],
        shopId: dynamicData['shop_id'],
        name: dynamicData['name'],
        description: dynamicData['description'],
        address: dynamicData['address'],
        phone: dynamicData['phone'],
        status: dynamicData['status'],
        addedDate: dynamicData['added_date'],
        addedUserId: dynamicData['added_user_id'],
        updatedDate: dynamicData['updated_date'],
        updatedUserId: dynamicData['updated_user_id'],
        updatedFlag: dynamicData['updated_flag'],
      );
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['shop_id'] = object.shopId;
      data['name'] = object.name;
      data['description'] = object.description;
      data['address'] = object.address;
      data['phone'] = object.phone;
      data['status'] = object.status;
      data['added_date'] = object.addedDate;
      data['added_user_id'] = object.addedUserId;
      data['updated_date'] = object.updatedDate;
      data['updated_user_id'] = object.updatedUserId;
      data['updated_flag'] = object.updatedFlag;
      return data;
    } else {
      return null;
    }
  }

  @override
  List<ShopBranch> fromMapList(List<dynamic> dynamicDataList) {
    final List<ShopBranch> branchlist = <ShopBranch>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          branchlist.add(fromMap(dynamicData));
        }
      }
    }
    return branchlist;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<dynamic> objectList) {
    final List<Map<String, dynamic>> dynamicList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (dynamic data in objectList) {
        if (data != null) {
          dynamicList.add(toMap(data));
        }
      }
    }
    return dynamicList;
  }
}
