import 'package:fluttermultigrocery/viewobject/category_map.dart';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart';

class CategoryMapDao extends PsDao<CategoryMap> {
  CategoryMapDao._() {
    init(CategoryMap());
  }
  static const String STORE_NAME = 'CategoryMap';
  final String _primaryKey = 'id';

  // Singleton instance
  static final CategoryMapDao _singleton = CategoryMapDao._();

  // Singleton accessor
  static CategoryMapDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(CategoryMap object) {
    return object.id;
  }

  @override
  Filter getFilter(CategoryMap object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
