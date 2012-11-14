class CreateCommnets < ActiveRecord::Migration
  def change
    create_table :commnets do |t|

      t.timestamps
    end
  end
end
