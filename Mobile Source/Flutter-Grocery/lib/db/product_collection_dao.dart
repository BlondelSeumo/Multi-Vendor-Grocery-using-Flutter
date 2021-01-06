import 'package:fluttermultigrocery/viewobject/product_collection.dart';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart';

class ProductCollectionDao extends PsDao<ProductCollection> {
  ProductCollectionDao._() {
    init(ProductCollection());
  }

  static const String STORE_NAME = 'ProductCollection';
  final String _primaryKey = 'id';
  final String collectionId = 'collection_id';

  // Singleton instance
  static final ProductCollectionDao _singleton = ProductCollectionDao._();

  // Singleton accessor
  static ProductCollectionDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(ProductCollection object) {
    return object.id;
  }

  @override
  Filter getFilter(ProductCollection object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
